<?php

namespace App\Http\Controllers\User;

use App\Entities\User;
use App\Entities\Winery;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Winery\WineryDeleteImageRequest;
use App\Http\Requests\User\Winery\WineryDestroyRequest;
use App\Http\Requests\User\Winery\WineryListRequest;
use App\Http\Requests\User\Winery\WineryShowRequest;
use App\Http\Requests\User\Winery\WineryStoreImageRequest;
use App\Http\Requests\User\Winery\WineryStoreRequest;
use App\Http\Requests\User\Winery\WineryUpdateRequest;
use App\Http\Requests\User\Winery\WineryUploadAvatarRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class WineryController extends Controller
{

    /**
     * Create new winery resource
     *
     * @param WineryStoreRequest $request
     * @param User $user
     * @param Winery $winery
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(WineryStoreRequest $request, User $user, Winery $winery, Role $role)
    {
        $request->merge($request->input('translation'));

        $role = $role->findByName('winery', 'web');

        try {
            $user = $user->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ]);

            $user->assignRole($role);

            $winery = $winery->create($request->input());

            $winery->user()->save($user);
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while saving winery', 500);
        }

        return $this->successDataResponse($winery, 200);
    }

    /**
     * Update winery resource
     *
     * @param WineryUpdateRequest $request
     * @param Winery $winery
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(WineryUpdateRequest $request, Winery $winery)
    {
        try {
            $winery->update([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'open_hours' => $request->input('open_hours'),
                'lat' => $request->input('lat'),
                'long' => $request->input('long')
            ]);

            foreach ($request->input('translation') as $language => $title) {
                foreach ($title as $key => $value) {
                    $query[$key] = $request->input("translation.{$language}.{$key}");
                }
                $winery->translations()->where('locale', $language)->update($query);
            }
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while updating winery', 500);
        }

        return $this->successDataResponse($winery, 200);
    }

    /**
     * Delete winery resource
     *
     * @param WineryDestroyRequest $request
     * @param Winery $winery
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(WineryDestroyRequest $request, Winery $winery)
    {
        try {
            $winery->delete();
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Winery deleted successfully', 500);
        }

        return $this->successMessageResponse('Winery deleted successfully', 200);
    }

    /**
     * Return single winery resource
     *
     * @param WineryShowRequest $request
     * @param Winery $winery
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(WineryShowRequest $request, Winery $winery)
    {
        $winery = $winery->load('translations');

        return $this->successDataResponse($winery, 200);
    }


    /**
     * Return list of winery resources
     *
     * @param WineryListRequest $request
     * @param Winery $winery
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(WineryListRequest $request, Winery $winery)
    {
        $winery = $winery->with('translations')->paginate(10);

        return $this->respondWithPagination($winery, 200);
    }

    /**
     * Upload winery avatar
     *
     * @param WineryUploadAvatarRequest $request
     * @param Winery $winery
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadAvatar(WineryUploadAvatarRequest $request, Winery $winery)
    {
        $delete = 'wineries/avatars' . '/' . $winery->id;

        Storage::disk('s3')->delete($delete);

        $request->avatar->storeAs('wineries/avatars' , $winery->id, 's3', "public");

        $url = Storage::cloud()->url('api-test-v2/wineries/avatars/'. $winery->id);

        return $this->successDataResponse($url, 200);
    }


    /**
     * Upload winery image
     *
     * @param WineryStoreImageRequest $request
     * @param Winery $winery
     * @return \Illuminate\Http\JsonResponse
     */
    public function postImage(WineryStoreImageRequest $request, Winery $winery)
    {
        $lastActive = '';
        $currentActive = '';

        for($i = 1; $i <= 6; $i++) {
            $id = 'image_' . $i;

            if($winery->{$id}) {
                $lastActive = $id;
            }

            if ($winery->{$id} && $i === 6) {
                $lastActive = null;
            }
        }

        if($lastActive === null) {
            return $this->errorMessageResponse('Maximum image number uploaded', 400);
        }

        if($lastActive === '') {
            $currentActive = 'image_1';
        } else {
            $lastActiveArray = explode('_', $lastActive);
            $lastActiveArray[1]++;

            $currentActive = implode('_', $lastActiveArray);
        }

        $wineryImgId = rand();

        $winery->{$currentActive} = $wineryImgId;
        $winery->save();

        $request->image->storeAs('wineries/gallery/' . $winery->id . '/' , $wineryImgId, 's3', "public");

        $url = Storage::cloud()->url('api-test-v2/wineries/gallery/'. $winery->id . '/' . $wineryImgId);

        return $this->successDataResponse($url, 200);
    }

    /**
     * Delete winery image
     *
     * @param WineryDeleteImageRequest $request
     * @param Winery $winery
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyImage(WineryDeleteImageRequest $request, Winery $winery)
    {
        for($i = 1; $i <= 6; $i++) {
            $id = 'image_' . $i;
            if($winery->{$id} == $request->input('image_id')) {
                $winery->{$id} = '';
                $winery->save();
                break;
            }
        }

        $delete = 'wineries/gallery/' . $winery->id . '/' . $request->input('image_id');

        Storage::disk('s3')->delete($delete);

        return $this->successDataResponse('Image deleted successfully', 200);
    }
}

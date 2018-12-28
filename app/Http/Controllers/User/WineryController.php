<?php

namespace App\Http\Controllers\User;

use App\Entities\Restaurant;
use App\Entities\User;
use App\Entities\Winery;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RestaurantUpdateRequest;
use App\Http\Requests\User\UploadAvatarRequest;
use App\Http\Requests\User\WineryStoreRequest;
use App\Http\Requests\User\WineryUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WineryController extends Controller
{

    /**
     * Create new winery resource
     *
     * @param WineryStoreRequest $request
     * @param User $user
     * @param Winery $winery
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(WineryStoreRequest $request, User $user, Winery $winery)
    {
        $request->merge($request->input('translation'));

        try {
            $user = $user->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('email'),
            ]);

            $winery = $winery->create($request->input());

            $winery->user()->save($user);
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while updating winery', 500);
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
     * @param Winery $winery
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Winery $winery)
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
     * @param Winery $winery
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Winery $winery)
    {
        $winery = $winery->load('translations');

        return $this->successDataResponse($winery, 200);
    }


    /**
     * Return list of winery resources
     *
     * @param Winery $winery
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Winery $winery)
    {
        $winery = $winery->with('translations')->paginate(10);

        return $this->respondWithPagination($winery, 200);
    }

    /**
     * Upload winery avatar
     *
     * @param UploadAvatarRequest $request
     * @return mixed
     */
    public function uploadAvatar(UploadAvatarRequest $request)
    {
        $winery = Auth::user();

        $delete = 'wineries/avatars' . '/' . $winery->id;

        Storage::disk('s3')->delete($delete);

        $request->avatar->storeAs('wineries/avatars' , $winery->id, 's3', "public");

        $url = Storage::cloud()->url('api-test-v2/wineries/avatars/'. $winery->id);

        return $this->successDataResponse($url, 200);
    }
}

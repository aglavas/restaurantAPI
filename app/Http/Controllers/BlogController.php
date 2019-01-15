<?php

namespace App\Http\Controllers;

use App\Entities\Blog;
use App\Http\Requests\Blog\BlogListRequest;
use App\Http\Requests\Blog\BlogStoreRequest;
use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Http\Requests\Blog\BlogDestroyRequest;
use App\Http\Requests\Blog\BlogShowRequest;
use App\Http\Requests\Blog\BlogUploadImageRequest;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    /**
     * Returns single blog entity
     *
     * @param BlogShowRequest $request
     * @param Blog $blog
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(BlogShowRequest $request, Blog $blog)
    {
        return $this->successDataResponse($blog, 200);
    }

    /**
     * Lists blog entites
     *
     * @param BlogListRequest $request
     * @param Blog $blog
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(BlogListRequest $request, Blog $blog)
    {
        $blog = $blog->paginate(10);

        return $this->respondWithPagination($blog, 200);
    }

    /**
     * Create blog post entity
     *
     * @param BlogStoreRequest $request
     * @param Blog $blog
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BlogStoreRequest $request, Blog $blog)
    {
        try {
            $blog = $blog->create($request->input());
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while saving blog post.', 500);
        }

        return $this->successDataResponse($blog, 200);
    }

    /**
     * Deletes blog post entity
     *
     * @param BlogDestroyRequest $request
     * @param Blog $blog
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BlogDestroyRequest $request, Blog $blog)
    {
        try {
            $blog->delete();
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while deleting blog post', 500);
        }

        return $this->successMessageResponse('Blog post deleted successfully', 200);
    }

    /**
     * Updates blog post entity
     *
     * @param BlogUpdateRequest $request
     * @param Blog $blog
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BlogUpdateRequest $request, Blog $blog)
    {
        try {
            $blog->update($request->input());
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while updating blog post', 500);
        }

        return $this->successDataResponse($blog, 200);
    }

    /**
     * Upload blog image
     *
     * @param BlogUploadImageRequest $request
     * @param Blog $blog
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(BlogUploadImageRequest $request, Blog $blog)
    {
        $delete = 'blog/' . $blog->id;

        Storage::disk('s3')->delete($delete);

        $request->image->storeAs('blog' , $blog->id, 's3', "public");

        $url = Storage::cloud()->url('api-test-v2/blog/'. $blog->id);

        return $this->successDataResponse($url, 200);
    }
}

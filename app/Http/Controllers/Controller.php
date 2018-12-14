<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Success data response
     *
     * @param $data
     * @param $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function successDataResponse($data, $statusCode)
    {
        return response()->json([
            'status' => 'success',
            'data' => $data
        ])->setStatusCode($statusCode);
    }

    /**
     * Error message response
     *
     * @param $message
     * @param $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorMessageResponse($message, $statusCode)
    {
        return response()->json([
            'status' => 'error',
            'message'=> $message
        ], $statusCode);
    }

    /**
     * Success message response
     *
     * @param $message
     * @param $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function successMessageResponse($message, $statusCode)
    {
        return response()->json([
            'status' => 'success',
            'message'=> $message
        ], $statusCode);
    }

    /**
     * Success response with pagination
     *
     * @param LengthAwarePaginator $paginator
     * @param int $status
     * @param string $contentType
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithPagination($paginator, $status=200, $contentType='application/json')
    {
        $response = [
            'meta' => [
                'currentPage' => $paginator->currentPage(),
                'totalItems' => $paginator->total(),
                'itemsPerPage' => $paginator->perPage(),
                'totalPages' => $paginator->lastPage(),
            ],
            'data' => $paginator->items(),
            'links' => [
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
                'self' => $paginator->url($paginator->currentPage()),
                'template' => url()->current() . "?%page%",
            ]
        ];

        return $this->successDataResponse($response, 200);
    }
}

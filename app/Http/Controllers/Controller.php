<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $validate_data
     * @return JsonResponse
     */
    public function validate_exception($validate_data): JsonResponse
    {
        return response()->json([
            'data' => $validate_data->messages(),
            'message' => 'Validation error.'
        ], 400);
    }

    /**
     * @return JsonResponse
     */
    public function not_found_exception(): JsonResponse
    {
        return response()->json([
            'data' => null,
            'message' => 'Field not found.'
        ], 401);
    }

    /**
     * @return JsonResponse
     */
    public function unknown_exception(): JsonResponse
    {
        return response()->json([
            'data' => null,
            'message' => 'Error.'
        ], 422);
    }
}

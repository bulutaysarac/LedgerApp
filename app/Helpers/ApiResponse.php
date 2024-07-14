<?php

namespace App\Helpers;

use App\Enums\ApiMessage;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * @param array $data
     * @param ApiMessage $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function success(array $data = [], ApiMessage $message = ApiMessage::SUCCESS, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message->value,
            'data' => $data
        ], $statusCode);
    }

    /**
     * @param ApiMessage $message
     * @param array $errors
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function error(ApiMessage $message = ApiMessage::ERROR, array $errors = [], int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message->value,
            'errors' => $errors
        ], $statusCode);
    }
}

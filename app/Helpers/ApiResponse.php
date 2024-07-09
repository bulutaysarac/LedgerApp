<?php

namespace App\Helpers;

use App\Enums\ApiMessage;

class ApiResponse
{
    public static function success($data = [], ApiMessage $message = ApiMessage::SUCCESS, $statusCode = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message->value,
            'data' => $data
        ], $statusCode);
    }

    public static function error(ApiMessage $message = ApiMessage::ERROR, $errors = [], $statusCode = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message->value,
            'errors' => $errors
        ], $statusCode);
    }
}

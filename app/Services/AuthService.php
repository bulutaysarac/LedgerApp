<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;
use App\Enums\ApiMessage;
use Exception;

class AuthService
{
    /**
     * @param string $email
     * @param string $password
     * @return JsonResponse
     */
    public function login(string $email, string $password): JsonResponse
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return ApiResponse::error(ApiMessage::INVALID_CREDENTIALS, [], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::success(['token' => $token], ApiMessage::LOGIN_SUCCESS);
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return JsonResponse
     */
    public function register(string $name, string $email, string $password): JsonResponse
    {
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            return ApiResponse::success(['user' => $user], ApiMessage::REGISTER_SUCCESS, 201);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessage::ERROR, ['exception' => $e->getMessage()], 500);
        }
    }
}

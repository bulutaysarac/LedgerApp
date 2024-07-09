<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;
use App\Enums\ApiMessage;
use Exception;

class AuthService
{
    public function login(string $email, string $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return ApiResponse::error(ApiMessage::INVALID_CREDENTIALS, [], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::success(['token' => $token], ApiMessage::LOGIN_SUCCESS);
    }

    public function register(string $name, string $email, string $password)
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

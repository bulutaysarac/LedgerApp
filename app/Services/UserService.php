<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * @param $payload
     * @return User
     */
    public function createUser($payload): User
    {
        return User::create([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => $payload['password'],
        ]);
    }
}

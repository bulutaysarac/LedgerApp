<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @param CreateUserRequest $request
     * @param UserService $userService
     * @return JsonResponse
     */
    function createUser(CreateUserRequest $request, UserService $userService): JsonResponse
    {
        $createdUser = $userService->createUser($request->validated());

        return response()->json(['success' => true, 'message' => 'User has been created successfully.', 'user' => $createdUser]);
    }
}

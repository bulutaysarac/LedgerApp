<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\GetUserBalanceRequest;
use App\Http\Requests\SendCreditToUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
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

        return response()->json(['success' => true, 'message' => 'User has been created successfully.', 'Created User' => $createdUser]);
    }

    /**
     * @param SendCreditToUserRequest $request
     * @param UserService $userService
     * @return JsonResponse
     */
    function sendCreditToUser(SendCreditToUserRequest $request, UserService $userService): JsonResponse
    {
        $createdBalance = $userService->sendCreditToUser($request->validated());

        return response()->json(['success' => true, 'message' => 'Credit sent to user successfully.', 'Sent Credit' => $createdBalance]);
    }

    /**
     * @param GetUserBalanceRequest $request
     * @param UserService $userService
     * @return JsonResponse
     */
    function getUserBalance(GetUserBalanceRequest $request, UserService $userService): JsonResponse
    {
        $userBalance = $userService->getUserBalance($request->validated());

        return response()->json(['success' => true,  'User Balance' => $userBalance]);
    }

    /**
     * @param Request $request
     * @param UserService $userService
     * @return JsonResponse
     */
    function getAllUserBalances(Request $request, UserService $userService): JsonResponse
    {
        $userBalances = $userService->getAllUserBalances();

        return response()->json(['success' => true,  'User Balances' => $userBalances]);
    }
}

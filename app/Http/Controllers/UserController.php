<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferCreditsRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @param UserService $userService
     */
    public function __construct(private readonly UserService $userService)
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * @return JsonResponse
     */
    public function showBalance(): JsonResponse
    {
        return $this->userService->showBalance();
    }

    /**
     * @param TransferCreditsRequest $request
     * @return JsonResponse
     */
    public function transferCredits(TransferCreditsRequest $request): JsonResponse
    {
        return $this->userService->transferCredits($request->recipient_id, $request->amount);
    }
}

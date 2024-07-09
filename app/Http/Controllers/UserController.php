<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferCreditsRequest;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth:sanctum');
        $this->userService = $userService;
    }

    public function showBalance()
    {
        return $this->userService->showBalance();
    }

    public function transferCredits(TransferCreditsRequest $request)
    {
        return $this->userService->transferCredits($request->recipient_id, $request->amount);
    }
}

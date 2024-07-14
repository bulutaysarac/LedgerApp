<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCreditsRequest;
use App\Http\Requests\GetBalanceAtTimeRequest;
use App\Services\CreditService;
use App\Services\BalanceService;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    /**
     * @param CreditService $creditService
     * @param BalanceService $balanceService
     */
    public function __construct(private readonly CreditService $creditService, private readonly BalanceService $balanceService)
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:admin');
    }

    /**
     * @param AddCreditsRequest $request
     * @return JsonResponse
     */
    public function addCredits(AddCreditsRequest $request): JsonResponse
    {
        return $this->creditService->addCredits($request->user_id, $request->amount);
    }

    /**
     * @param int $userId
     * @return JsonResponse
     */
    public function viewBalance(int $userId): JsonResponse
    {
        return $this->balanceService->viewBalance($userId);
    }

    /**
     * @return JsonResponse
     */
    public function getAllBalances(): JsonResponse
    {
        return $this->balanceService->getAllBalances();
    }

    /**
     * @param GetBalanceAtTimeRequest $request
     * @return JsonResponse
     */
    public function getBalanceAtTime(GetBalanceAtTimeRequest $request): JsonResponse
    {
        return $this->balanceService->getBalanceAtTime($request->user_id, $request->time);
    }
}

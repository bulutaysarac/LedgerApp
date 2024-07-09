<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCreditsRequest;
use App\Http\Requests\GetBalanceAtTimeRequest;
use App\Services\CreditService;
use App\Services\BalanceService;

class AdminController extends Controller
{
    protected $creditService;
    protected $balanceService;

    public function __construct(CreditService $creditService, BalanceService $balanceService)
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:admin');
        $this->creditService = $creditService;
        $this->balanceService = $balanceService;
    }

    public function addCredits(AddCreditsRequest $request)
    {
        return $this->creditService->addCredits($request->user_id, $request->amount);
    }

    public function viewBalance($userId)
    {
        return $this->balanceService->viewBalance($userId);
    }

    public function getAllBalances()
    {
        return $this->balanceService->getAllBalances();
    }

    public function getBalanceAtTime(GetBalanceAtTimeRequest $request)
    {
        return $this->balanceService->getBalanceAtTime($request->user_id, $request->time);
    }
}

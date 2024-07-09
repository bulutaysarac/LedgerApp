<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use App\Helpers\ApiResponse;
use App\Enums\ApiMessage;
use Exception;

class BalanceService
{
    public function viewBalance(int $userId)
    {
        try {
            $user = User::findOrFail($userId);

            if ($user->hasRole('admin')) {
                return ApiResponse::success(['balance' => 'infinite'], ApiMessage::USER_BALANCE_RETRIEVED_SUCCESS);
            }

            return ApiResponse::success(['balance' => $user->balance], ApiMessage::USER_BALANCE_RETRIEVED_SUCCESS);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessage::RETRIEVE_USER_BALANCE_FAILED, ['exception' => $e->getMessage()]);
        }
    }

    public function getAllBalances()
    {
        try {
            $balances = User::all(['id', 'name', 'balance'])->toArray();
            return ApiResponse::success($balances, ApiMessage::ALL_BALANCES_RETRIEVED_SUCCESS);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessage::RETRIEVE_ALL_BALANCES_FAILED, ['exception' => $e->getMessage()]);
        }
    }

    public function getBalanceAtTime(int $userId, string $time)
    {
        try {
            $transactions = Transaction::where('user_id', $userId)
                ->where('created_at', '<=', $time)
                ->get();

            $balance = 0;
            foreach ($transactions as $transaction) {
                if ($transaction->type == 'credit') {
                    $balance += $transaction->amount;
                } elseif ($transaction->type == 'debit') {
                    $balance -= $transaction->amount;
                }
            }

            return ApiResponse::success(['balance' => $balance], ApiMessage::BALANCE_AT_TIME_RETRIEVED_SUCCESS);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessage::RETRIEVE_BALANCE_AT_TIME_FAILED, ['exception' => $e->getMessage()]);
        }
    }
}

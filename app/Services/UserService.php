<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use App\Enums\ApiMessage;
use Exception;

class UserService
{
    public function showBalance()
    {
        try {
            $user = Auth::user();

            if ($user->hasRole('admin')) {
                return ApiResponse::success(['balance' => 'infinite'], ApiMessage::USER_BALANCE_RETRIEVED_SUCCESS);
            }

            return ApiResponse::success(['balance' => $user->balance], ApiMessage::USER_BALANCE_RETRIEVED_SUCCESS);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessage::RETRIEVE_USER_BALANCE_FAILED, ['exception' => $e->getMessage()]);
        }
    }

    public function transferCredits(int $recipientId, float $amount)
    {
        try {
            $sender = Auth::user();
            $recipient = User::findOrFail($recipientId);

            if ($sender->hasRole('admin') || $sender->balance >= $amount) {
                if (!$sender->hasRole('admin')) {
                    $sender->balance -= $amount;
                    $sender->save();
                }
                $recipient->balance += $amount;
                $recipient->save();

                Transaction::create([
                    'user_id' => $sender->id,
                    'type' => 'debit',
                    'amount' => $amount
                ]);

                Transaction::create([
                    'user_id' => $recipient->id,
                    'type' => 'credit',
                    'amount' => $amount
                ]);

                return ApiResponse::success([], ApiMessage::TRANSFER_SUCCESS);
            } else {
                return ApiResponse::error(ApiMessage::INSUFFICIENT_BALANCE, [], 400);
            }
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessage::ERROR, ['exception' => $e->getMessage()], 500);
        }
    }
}

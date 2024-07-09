<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use App\Enums\ApiMessage;
use Exception;

class CreditService
{
    public function addCredits(int $userId, float $amount)
    {
        try {
            $admin = Auth::user();
            $user = User::findOrFail($userId);

            $user->balance += $amount;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'credit',
                'amount' => $amount,
                'admin_id' => $admin->id,
            ]);

            return ApiResponse::success([], ApiMessage::CREDITS_ADDED_SUCCESS);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessage::ADD_CREDITS_FAILED, ['exception' => $e->getMessage()]);
        }
    }
}

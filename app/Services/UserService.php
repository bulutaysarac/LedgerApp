<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use App\Enums\ApiMessage;
use Exception;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * @return JsonResponse
     */
    public function showBalance(): JsonResponse
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

    /**
     * @param int $recipientId
     * @param float $amount
     * @return JsonResponse
     */
    public function transferCredits(int $recipientId, float $amount): JsonResponse
    {
        try {
            DB::beginTransaction();

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

                DB::commit();

                return ApiResponse::success([], ApiMessage::TRANSFER_SUCCESS);
            } else {
                DB::rollBack();

                return ApiResponse::error(ApiMessage::INSUFFICIENT_BALANCE, [], 400);
            }
        } catch (Exception $e) {
            DB::rollBack();

            return ApiResponse::error(ApiMessage::ERROR, ['exception' => $e->getMessage()], 500);
        }
    }
}

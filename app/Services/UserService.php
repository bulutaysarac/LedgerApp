<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * @param $payload
     * @return User
     */
    public function createUser($payload): User
    {
        return User::create([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => $payload['password'],
        ]);
    }

    /**
     * @param $payload
     * @return object
     */
    public function sendCreditToUser($payload): object
    {
        return Transaction::create([
            'userId' => $payload['userId'],
            'senderId' => 1,
            'amount' => $payload['amount'],
        ]);
    }

    /**
     * @param $payload
     * @return float
     */
    public function getUserBalance($payload): float
    {
        $positiveBalance = Transaction::where('userId', $payload['userId'])->sum('amount');
        $negativeBalance = Transaction::where('senderId', $payload['userId'])->sum('amount');

        return number_format($positiveBalance - $negativeBalance, 2);
    }

    /**
     * @return object
     */
    public function getAllUserBalances(): object
    {
        $positiveBalances = Transaction::select('userId', DB::raw('SUM(amount) as total_positive_balance'))
            ->where('userId', '<>', 1) // Exclude superadmin
            ->groupBy('userId')
            ->get()
            ->keyBy('userId');

        $negativeBalances = Transaction::select('senderId as userId', DB::raw('SUM(amount) as total_negative_balance'))
            ->where('senderId', '<>', 1) // Exclude superadmin
            ->groupBy('senderId')
            ->get()
            ->keyBy('userId');

        $userIds = $positiveBalances->keys()->merge($negativeBalances->keys())->unique();

        return $userIds->map(function ($userId) use ($positiveBalances, $negativeBalances) {
            $positiveBalance = $positiveBalances->get($userId)->total_positive_balance ?? 0;
            $negativeBalance = $negativeBalances->get($userId)->total_negative_balance ?? 0;
            $netBalance = $positiveBalance - $negativeBalance;

            $user = User::find($userId);

            return [
                'userId' => $userId,
                'name' => $user->name,
                'email' => $user->email,
                'net_balance' => number_format($netBalance, 2)
            ];
        });
    }
}

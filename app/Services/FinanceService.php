<?php

namespace App\Services;

use App\Models\UserModel;

class FinanceService
{
    /**
     * @return array{
     *  userId:int,
     *  walletBalance:float,
     *  isGold:bool
     * }
     */
    public function getFinanceData(int $userId): array
    {
        $user = (new UserModel())->find($userId);

        if (!$user) {
            throw new \RuntimeException('Utilisateur introuvable');
        }

        return [
            'userId' => $userId,
            'walletBalance' => (float)($user['wallet_balance'] ?? 0),
            'isGold' => (int)($user['is_gold'] ?? 0) === 1,
        ];
    }
}

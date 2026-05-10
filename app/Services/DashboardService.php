<?php

namespace App\Services;

use App\Models\ConfigSystemModel;
use App\Models\SubscriptionModel;
use App\Models\UserModel;

class DashboardService
{
    public function getDashboardData(int $userId): array
    {
        $user = (new UserModel())->find($userId);
        if (!$user) {
            throw new \RuntimeException('Utilisateur introuvable');
        }

        // Gold actif
        $isGold = (int)($user['is_gold'] ?? 0) === 1;

        // Wallet
        $walletBalance = (float)($user['wallet_balance'] ?? 0);

        // IMC + ideal
        $imcService = new ImcService();
        $poids = (float)($user['poids'] ?? 0);
        $taille = (float)($user['taille'] ?? 0);
        $imc = $imcService->calculateIMC($poids, $taille);

        $objectiveLabel = $this->getObjectiveLabel((string)($user['objectif'] ?? $user['objective'] ?? 'ideal'));

        // Ideal weight selon service
        $idealWeight = $imcService->calculateIdealWeight($taille);

        // Progress (optionnel, si tu as un historique de poids initial/cible, sinon placeholder)
        $healthProgress = null;

        // Gold discount
        $config = new ConfigSystemModel();
        $goldDiscountPct = (float)$config->getValue('gold_discount', '15'); // ex: 15
        $goldDiscount = max(0.0, min(1.0, $goldDiscountPct / 100));

        // Subscription active
        $activeSubscription = (new SubscriptionModel())
            ->where('user_id', $userId)
            ->where('date_fin >=', date('Y-m-d'))
            ->orderBy('date_fin', 'DESC')
            ->first();

        return [
            'userId' => $userId,
            'userFirstName' => (string)($user['prenom'] ?? ''),
            'userLastName' => (string)($user['nom'] ?? ''),
            'isGold' => $isGold,
            'walletBalance' => $walletBalance,

            'poids' => $poids,
            'taille' => $taille,
            'imc' => $imc,
            'idealWeight' => $idealWeight,
            'objectiveLabel' => $objectiveLabel,

            'healthProgress' => $healthProgress,

            'goldDiscountPct' => $goldDiscountPct,
            'goldDiscount' => $goldDiscount,

            'activeSubscription' => $activeSubscription,
        ];
    }

    private function getObjectiveLabel(string $objective): string
    {
        return match ($objective) {
            'increase' => 'Augmenter',
            'reduce' => 'Réduire',
            'ideal' => 'IMC idéal',
            default => 'IMC idéal',
        };
    }
}

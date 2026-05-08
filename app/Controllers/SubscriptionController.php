<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PrixRegimeModel;
use App\Models\SubscriptionModel;

class SubscriptionController extends BaseController
{
    public function subscribe()
    {
        $userId = session()->get('user_id');

        $regimeId =
            $this->request->getPost('regime_id');

        $duree =
            $this->request->getPost('duree_mois');

        $userModel = new UserModel();

        $prixModel = new PrixRegimeModel();

        $subscriptionModel =
            new SubscriptionModel();

        $user =
            $userModel->find($userId);

        $prixData =
            $prixModel
            ->where('regime_id', $regimeId)
            ->where('duree_mois', $duree)
            ->first();

        if (!$prixData) {

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Prix introuvable'
            ]);
        }

        $prix = $prixData['prix'];

        if ($user['is_gold']) {

            $prix = $prix * 0.85;
        }

        if ($user['wallet_balance'] < $prix) {

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Solde insuffisant'
            ]);
        }

        $nouveauSolde =
            $user['wallet_balance'] - $prix;

        $userModel->update($userId, [
            'wallet_balance' => $nouveauSolde
        ]);

        $dateDebut = date('Y-m-d');

        $dateFin =
            date(
                'Y-m-d',
                strtotime("+$duree month")
            );

        $subscriptionModel->save([
            'user_id' => $userId,
            'regime_id' => $regimeId,
            'duree_mois' => $duree,
            'prix_paye' => $prix,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Abonnement active',
            'solde' => $nouveauSolde
        ]);
    }
}
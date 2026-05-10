<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ConfigSystemModel;

class GoldController extends BaseController
{
    public function upgrade()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON([
                'success' => false,
                'message' => 'Utilisateur non connecte'
            ]);
        }

        $prixGold = (float) (new ConfigSystemModel())->getValue('gold_price', '50000');

        $userModel = new UserModel();

        $user = $userModel->find($userId);

        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Utilisateur introuvable'
            ]);
        }

        if ((int) $user['is_gold'] === 1) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Compte deja Gold',
                'solde' => (float) $user['wallet_balance']
            ]);
        }

        if ($user['wallet_balance'] < $prixGold) {

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Solde insuffisant'
            ]);
        }

        $nouveauSolde =
            $user['wallet_balance']
            - $prixGold;

        $userModel->update($userId, [
            'wallet_balance' => $nouveauSolde,
            'is_gold' => 1
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Gold active',
            'solde' => $nouveauSolde
        ]);
    }
}
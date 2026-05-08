<?php

namespace App\Controllers;

use App\Models\UserModel;

class GoldController extends BaseController
{
    public function upgrade()
    {
        $prixGold = 50000;

        $userId = session()->get('user_id');

        $userModel = new UserModel();

        $user = $userModel->find($userId);

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
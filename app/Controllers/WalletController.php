<?php

namespace App\Controllers;

use App\Models\CodeModel;
use App\Models\UserModel;
use App\Models\RechargeHistoryModel;

class WalletController extends BaseController
{
    public function recharge()
    {
        $codeValue = $this->request->getPost('code');

        $codeModel = new CodeModel();
        $userModel = new UserModel();
        $historyModel = new RechargeHistoryModel();

        $code = $codeModel
            ->where('code', $codeValue)
            ->where('is_used', 0)
            ->first();

        if (!$code) {

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Code invalide'
            ]);
        }

        $userId = session()->get('user_id');

        $user = $userModel->find($userId);

        $nouveauSolde =
            $user['wallet_balance']
            + $code['valeur'];

        $userModel->update($userId, [
            'wallet_balance' => $nouveauSolde
        ]);

        $codeModel->update($code['id'], [
            'is_used' => 1,
            'used_by' => $userId,
            'used_at' => date('Y-m-d H:i:s')
        ]);

        $historyModel->save([
            'user_id' => $userId,
            'code_id' => $code['id'],
            'montant' => $code['valeur']
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Recharge effectuee',
            'solde' => $nouveauSolde
        ]);
    }
}
<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use App\Services\ImcService;
use App\Traits\ApiResponseTrait;

class ObjectiveController extends ResourceController
{
    use ApiResponseTrait;

    public function updateObjective()
    {
        $userId = session()->get('user_id');
        $poidsCible = $this->request->getVar('poids_cible');
        $objectif_type = $this->request->getVar('objectif_type'); // perte, prise, equilibre

        if (!$poidsCible) return $this->sendError("poids_cible requis");

        $userModel = new UserModel();
        $user = $userModel->find($userId);
        
        $imcService = new ImcService();
        $imcFuture = $imcService->calculateIMC((float)$poidsCible, (float)$user['taille']);
        $categorieFuture = $imcService->getIMCCategory($imcFuture);

        if ($categorieFuture === 'maigreur' || $categorieFuture === 'obésité') {
            return $this->sendError("Alerte de santé : Ce poids cible conduit à une catégorie à risque ($categorieFuture).", 400);
        }

        $userModel->update($userId, ['poids_cible' => $poidsCible]);

        return $this->sendSuccess("Objectif mis à jour", [
            'nouveau_poids_cible' => $poidsCible,
            'imc_vise' => $imcFuture,
            'categorie_visee' => $categorieFuture
        ]);
    }
}
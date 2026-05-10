<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use App\Services\ImcService;
use App\Services\EstimationService;
use App\Models\RegimeModel;
use App\Traits\ApiResponseTrait;

class ObjectiveController extends ResourceController
{
    use ApiResponseTrait;

    public function updateObjective()
    {
        $userId = session()->get('user_id');
        $poidsCible = (float) ($this->request->getVar('poids_cible') ?? 0);
        $objectifType = (string) ($this->request->getVar('objectif_type') ?? '');

        if (!in_array($objectifType, ['perte', 'prise', 'equilibre'], true)) {
            return $this->sendError('objectif_type invalide (perte|prise|equilibre)');
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return $this->sendError('Utilisateur introuvable', 404);
        }

        if ($poidsCible <= 0) {
            $poidsCible = (float) $user['poids'];
        }
        
        $imcService = new ImcService();
        $imcFuture = $imcService->calculateIMC($poidsCible, (float) $user['taille']);
        $categorieFuture = $imcService->getIMCCategory($imcFuture);

        if (in_array($categorieFuture, ['maigreur', 'obesite'], true)) {
            return $this->sendError("Alerte sante: ce poids cible conduit a une categorie a risque ($categorieFuture).", 400);
        }

        // On conserve l'objectif en session car le schema SQL actuel ne stocke pas de poids_cible.
        session()->set('objectif_type', $objectifType);
        session()->set('poids_cible', $poidsCible);

        $estimation = (new EstimationService())->estimateDuration(
            (float) $user['poids'],
            $poidsCible,
            3.0
        );

        $regimes = (new RegimeModel())
            ->where('objectif', $objectifType)
            ->findAll();

        return $this->sendSuccess('Objectif mis a jour', [
            'objectif_type' => $objectifType,
            'nouveau_poids_cible' => $poidsCible,
            'imc_vise' => $imcFuture,
            'categorie_visee' => $categorieFuture,
            'estimation' => $estimation,
            'regimes_recommandes' => $regimes,
        ]);
    }
}
<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\RegimeModel;
use App\Models\UserModel;
use App\Services\ImcService;
use App\Traits\ApiResponseTrait;

class SuggestionController extends ResourceController
{
    use ApiResponseTrait;

    public function getRegimes()
    {
        $userId = session()->get('user_id');
        $user = (new UserModel())->find($userId);

        if (!$user) {
            return $this->sendError('Utilisateur introuvable', 404);
        }
        
        $imcService = new ImcService();
        $imc = $imcService->calculateIMC((float) $user['poids'], (float) $user['taille']);
        $categorie = $imcService->getIMCCategory($imc);

        // Priorite: objectif explicite (query/session), sinon inferer depuis l'IMC.
        $objectifParam = $this->request->getGet('objectif');
        $objectifSession = session()->get('objectif_type');
        $objectifRecherche = 'equilibre';

        if (in_array($objectifParam, ['perte', 'prise', 'equilibre'], true)) {
            $objectifRecherche = $objectifParam;
        } elseif (in_array($objectifSession, ['perte', 'prise', 'equilibre'], true)) {
            $objectifRecherche = $objectifSession;
        } else {
            if (in_array($categorie, ['surpoids', 'obesite'], true)) {
                $objectifRecherche = 'perte';
            }

            if ($categorie === 'maigreur') {
                $objectifRecherche = 'prise';
            }
        }

        $regimes = (new RegimeModel())
            ->where('objectif', $objectifRecherche)
            ->findAll();

        return $this->sendSuccess('Regimes suggeres bases sur votre profil', [
            'imc_actuel' => $imc,
            'categorie' => $categorie,
            'objectif' => $objectifRecherche,
            'regimes_recommandes' => $regimes
        ]);
    }

    public function getSports()
    {
        $db = \Config\Database::connect();
        $regimeId = (int) ($this->request->getGet('regime_id') ?? 0);

        if ($regimeId > 0) {
            $sports = $db->table('sports s')
                ->select('s.*')
                ->join('regime_sports rs', 'rs.sport_id = s.id', 'inner')
                ->where('rs.regime_id', $regimeId)
                ->orderBy('s.calories_brulees', 'DESC')
                ->get()
                ->getResultArray();

            return $this->sendSuccess('Sports du regime selectionne', ['sports' => $sports]);
        }

        $sports = $db->table('sports')
                     ->orderBy('calories_brulees', 'DESC')
                     ->get()->getResultArray();

        return $this->sendSuccess('Liste des sports', ['sports' => $sports]);
    }
}
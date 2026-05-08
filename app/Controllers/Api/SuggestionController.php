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
        
        $imcService = new ImcService();
        $imc = $imcService->calculateIMC($user['poids'], $user['taille']);
        $categorie = $imcService->getIMCCategory($imc);

        // Logique de suggestion
        $objectifRecherche = 'equilibre';
        if ($categorie === 'surpoids' || $categorie === 'obésité') $objectifRecherche = 'perte';
        if ($categorie === 'maigreur') $objectifRecherche = 'prise';

        $db = \Config\Database::connect();
        $regimes = $db->table('regimes')
                      ->where('objectif', $objectifRecherche)
                      ->get()->getResultArray();

        return $this->sendSuccess("Régimes suggérés basés sur votre profil", [
            'imc_actuel' => $imc,
            'categorie' => $categorie,
            'regimes_recommandes' => $regimes
        ]);
    }

    public function getSports()
    {
        $db = \Config\Database::connect();
        $sports = $db->table('sports')
                     ->orderBy('calories_brulees', 'DESC')
                     ->get()->getResultArray();

        return $this->sendSuccess("Liste des sports", ['sports' => $sports]);
    }
}
<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\WeightHistoryModel;
use App\Models\UserModel;
use App\Traits\ApiResponseTrait;

class WeightController extends ResourceController
{
    use ApiResponseTrait;

    public function addWeight()
    {
        $poids = (float) ($this->request->getVar('poids') ?? 0);
        $date = $this->request->getVar('date_mesure') ?? date('Y-m-d');
        $userId = session()->get('user_id');

        if ($poids <= 0) {
            return $this->sendError('Poids invalide');
        }

        $model = new WeightHistoryModel();
        
        if ($model->insert(['user_id' => $userId, 'poids' => $poids, 'date_mesure' => $date])) {
            // Mise à jour du profil utilisateur
            (new UserModel())->update($userId, ['poids' => $poids]);
            return $this->sendSuccess("Poids ajouté avec succès");
        }
        
        return $this->sendError($model->errors());
    }

    public function getHistory()
    {
        $userId = session()->get('user_id');
        $history = (new WeightHistoryModel())
            ->where('user_id', $userId)
            ->orderBy('date_mesure', 'DESC')
            ->findAll();

        return $this->sendSuccess('Historique du poids', [
            'history' => $history,
        ]);
    }

    public function getChartData()
    {
        $userId = session()->get('user_id');
        $model = new WeightHistoryModel();
        
        $history = $model->where('user_id', $userId)->orderBy('date_mesure', 'ASC')->findAll();
        
        $labels = [];
        $data = [];
        
        foreach ($history as $h) {
            $labels[] = $h['date_mesure'];
            $data[] = (float)$h['poids'];
        }

        return $this->sendSuccess("Données Chart.js", [
            'chart_data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => 'Évolution du poids (kg)',
                    'data' => $data,
                    'borderColor' => '#007bff'
                ]]
            ]
        ]);
    }
}
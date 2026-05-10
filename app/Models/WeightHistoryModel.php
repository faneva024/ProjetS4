<?php

namespace App\Models;

use CodeIgniter\Model;

class WeightHistoryModel extends Model
{
    protected $table         = 'weight_history';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['user_id', 'poids', 'date_mesure'];

    protected $validationRules = [
        'user_id'     => 'required|is_not_unique[users.id]',
        'poids'       => 'required|numeric|greater_than[0]',
        'date_mesure' => 'required|valid_date'
    ];
}
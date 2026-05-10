<?php

namespace App\Models;

use CodeIgniter\Model;

class RechargeHistoryModel extends Model
{
    protected $table = 'recharge_history';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'code_id',
        'montant'
    ];
}
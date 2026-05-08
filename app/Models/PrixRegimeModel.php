<?php

namespace App\Models;

use CodeIgniter\Model;

class PrixRegimeModel extends Model
{
    protected $table = 'prix_regime';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'regime_id',
        'duree_mois',
        'prix'
    ];
}
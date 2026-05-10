<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table = 'regimes';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nom',
        'description',
        'objectif',
        'pct_viande',
        'pct_poisson',
        'pct_volaille',
        'calories_jour',
        'duree_moyenne'
    ];
}
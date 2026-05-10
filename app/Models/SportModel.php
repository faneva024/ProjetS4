<?php

namespace App\Models;

use CodeIgniter\Model;

class SportModel extends Model
{
    protected $table = 'sports';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nom',
        'description',
        'difficulte',
        'calories_brulees',
        'duree_min',
        'frequence_semaine'
    ];
}
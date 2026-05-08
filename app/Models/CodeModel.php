<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeModel extends Model
{
    protected $table = 'codes';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'code',
        'valeur',
        'is_used',
        'used_by',
        'used_at'
    ];
}
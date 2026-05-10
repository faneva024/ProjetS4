<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigSystemModel extends Model
{
    protected $table = 'config_system';
    protected $primaryKey = 'cle';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';

    protected $allowedFields = [
        'cle',
        'valeur',
    ];

    public function getValue(string $key, string $default = '0'): string
    {
        $row = $this->find($key);

        return $row['valeur'] ?? $default;
    }
}
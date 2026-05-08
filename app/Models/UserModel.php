<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nom',
        'prenom',
        'genre',
        'email',
        'password_hash',
        'taille',
        'poids',
        'is_gold',
        'wallet_balance',
        'role'
    ];

    // Validation Backend
    protected $validationRules = [
        'nom'           => 'required|min_length[2]|max_length[100]',
        'prenom'        => 'required|min_length[2]|max_length[100]',
        'email'         => 'required|valid_email|is_unique[users.email]',
        'password_hash' => 'required|min_length[6]',
        'taille'        => 'required|numeric|greater_than[50]',
        'poids'         => 'required|numeric|greater_than[20]'
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Cette adresse email est déjà utilisée.'
        ]
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password_hash'])) {
            $data['data']['password_hash'] = password_hash($data['data']['password_hash'], PASSWORD_BCRYPT);
        }
        return $data;
    }

}
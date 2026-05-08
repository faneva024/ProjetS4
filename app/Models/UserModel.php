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
}
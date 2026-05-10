<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriptionModel extends Model
{
    protected $table = 'subscriptions';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'regime_id',
        'duree_mois',
        'prix_paye',
        'date_debut',
        'date_fin'
    ];
}
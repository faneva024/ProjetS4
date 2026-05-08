<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SubscriptionModel;

class AdminController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        $subscriptionModel =
            new SubscriptionModel();

        $data['total_users'] =
            $userModel->countAll();

        $data['total_gold'] =
            $userModel
            ->where('is_gold', 1)
            ->countAllResults();

        $data['total_subscriptions'] =
            $subscriptionModel->countAll();

        return view(
            'admin/dashboard',
            $data
        );
    }
}
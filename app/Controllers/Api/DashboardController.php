<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use App\Models\SubscriptionModel;
use App\Services\ImcService;
use App\Traits\ApiResponseTrait;

class DashboardController extends ResourceController
{
	use ApiResponseTrait;

	public function profile()
	{
		$userId = session()->get('user_id');
		$user = (new UserModel())->find($userId);

		if (!$user) {
			return $this->sendError('Utilisateur introuvable', 404);
		}

		unset($user['password_hash']);

		$activeSubscription = (new SubscriptionModel())
			->where('user_id', $userId)
			->where('date_fin >=', date('Y-m-d'))
			->orderBy('date_fin', 'DESC')
			->first();

		return $this->sendSuccess('Profil utilisateur', [
			'user' => $user,
			'active_subscription' => $activeSubscription,
		]);
	}

	public function imc()
	{
		$userId = session()->get('user_id');
		$user = (new UserModel())->find($userId);

		if (!$user) {
			return $this->sendError('Utilisateur introuvable', 404);
		}

		$imcService = new ImcService();
		$imc = $imcService->calculateIMC((float) $user['poids'], (float) $user['taille']);

		return $this->sendSuccess('Analyse IMC', [
			'imc' => $imc,
			'categorie' => $imcService->getIMCCategory($imc),
			'poids_ideal' => $imcService->calculateIdealWeight((float) $user['taille']),
		]);
	}
}

<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use App\Traits\ApiResponseTrait;

class AuthController extends ResourceController
{
    use ApiResponseTrait;

    public function register()
    {
        $rules = [
            'nom'      => 'required|min_length[2]',
            'prenom'   => 'required|min_length[2]',
            'genre'    => 'required|in_list[H,F]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'taille'   => 'required|numeric',
            'poids'    => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return $this->sendError($this->validator->getErrors());
        }

        $userModel = new UserModel();
        $data = [
            'nom'           => $this->request->getVar('nom'),
            'prenom'        => $this->request->getVar('prenom'),
            'genre'         => $this->request->getVar('genre'),
            'email'         => $this->request->getVar('email'),
            'password_hash' => $this->request->getVar('password'), // Hashé dans UserModel
            'taille'        => $this->request->getVar('taille'),
            'poids'         => $this->request->getVar('poids')
        ];

        if ($userModel->insert($data)) {
            return $this->sendSuccess("Utilisateur créé avec succès", ['id' => $userModel->getInsertID()], 201);
        }

        return $this->sendError("Erreur lors de la création", 500);
    }

    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->sendError($this->validator->getErrors());
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $this->request->getVar('email'))->first();

        if ($user && password_verify($this->request->getVar('password'), $user['password_hash'])) {
            // Création de la session
            session()->set([
                'user_id'      => $user['id'],
                'role'         => $user['role'],
                'is_logged_in' => true
            ]);

            unset($user['password_hash']); // Sécurité
            return $this->sendSuccess("Connexion réussie", ['user' => $user]);
        }

        return $this->sendError("Identifiants invalides", 401);
    }

    public function logout()
    {
        session()->destroy();
        return $this->sendSuccess("Déconnexion réussie");
    }
}
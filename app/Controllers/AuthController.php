<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    protected $session;
    protected $userModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->userModel = new UserModel();
    }

    // Affiche l'étape 1 : Identité
    public function registerStep1()
    {
        return view('auth/inscription_identite');
    }

    // Traite l'étape 1 et redirige vers l'étape 2
    public function storeStep1()
    {
        $data = [
            'nom'    => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'genre'  => $this->request->getPost('genre'),
            'email'  => $this->request->getPost('email'),
            'password_hash' => $this->request->getPost('password'), // Sera haché par le Model
        ];

        // On stocke temporairement en session
        $this->session->set('temp_user', $data);

        return redirect()->to('/register/step2');
    }

    // Affiche l'étape 2 : Santé (Ton HTML actuel)
    public function registerStep2()
    {
        $session = \Config\Services::session();
        // Debug : affiche tout ce qu'il y a en session
        // print_r($session->get()); 
        return view('auth/inscription_sante');

        if (!$this->session->has('temp_user')) {
            return redirect()->to('/register/step1');
        }
        return view('auth/inscription_sante');
    }

    // Finalise l'inscription en base de données
    public function finalizeRegister()
    {
        $userData = $this->session->get('temp_user');

        if (!$userData) {
            return $this->response->setJSON([
                'status' => 'error', 
                'errors' => ['session' => 'Session expirée, veuillez recommencer.']
            ]);
        }

        // Récupération des données POST
        $userData['taille'] = $this->request->getPost('taille');
        $userData['poids']  = $this->request->getPost('poids');
        $userData['objectif'] = $this->request->getPost('objectif');

        if ($this->userModel->insert($userData)) {
            $this->session->remove('temp_user');
            return $this->response->setJSON([
                'status' => 'success',
                'redirect' => base_url('idfit_dashboard_user.php') 
            ]);
        } else {
            // Renvoie les erreurs du Model (ex: email déjà pris)
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->userModel->errors()
            ]);
        }
    }


    public function registerFull() {

        $rules = [
            'email' => 'required|is_unique[users.email]',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
        }

        $data = [
            'nom'    => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'email'  => $this->request->getPost('email'),
            'password_hash' => $this->request->getPost('password'),
            'genre'  => $this->request->getPost('genre'),
            'taille' => $this->request->getPost('taille'),
            'poids'  => $this->request->getPost('poids'),
            'objectif' => $this->request->getPost('objectif'),
        ];

        if ($this->userModel->insert($data)) {
            return $this->response->setJSON([
                'status' => 'success', 
                'redirect' => base_url('idfit_dashboard_user.php')
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'errors' => $this->userModel->errors()
        ]);
    }
}
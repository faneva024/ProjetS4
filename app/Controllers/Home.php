<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    public function index(): ResponseInterface
    {
        return $this->renderTemplateFile('vitrine.php');
    }

    public function connexion(): ResponseInterface
    {
        return $this->renderTemplateFile('idfit_connexion.php');
    }

    public function inscriptionIdentite(): ResponseInterface
    {
        return $this->renderTemplateFile('idfit_inscription_identite.php');
    }

    public function inscriptionSante(): ResponseInterface
    {
        return $this->renderTemplateFile('idfit_inscription_sante.php');
    }

    public function dashboardUser(): ResponseInterface
    {
        $userId = session()->get('user_id');
        if (!$userId && !session()->get('is_logged_in')) {
            return redirect()->to(base_url('connexion'));
        }

        $data = (new \App\Services\DashboardService())->getDashboardData((int) $userId);

        return $this->renderTemplateFile('idfit_dashboard_user.php', $data);
    }

    public function regimes(): ResponseInterface
    {
        $userId = session()->get('user_id');
        $data = $userId ? (new \App\Services\DashboardService())->getDashboardData((int) $userId) : [];
        return $this->renderTemplateFile('idfit_regimes.php', $data);
    }

    public function finance(): ResponseInterface
    {
        $userId = session()->get('user_id');
        if (!$userId && !session()->get('is_logged_in')) {
            return redirect()->to(base_url('connexion'));
        }

        // On récupère les données de profil pour le header via le DashboardService
        $data = (new \App\Services\DashboardService())->getDashboardData((int) $userId);
        
        return $this->renderTemplateFile('idfit_finance.php', $data);
    }

    public function adminPreview(): ResponseInterface
    {
        return $this->renderTemplateFile('idfit_admin.php');
    }

    private function renderTemplateFile(string $fileName, array $data = []): ResponseInterface
    {
        $path = ROOTPATH . 'template/' . $fileName;

        if (!is_file($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Template introuvable: ' . $fileName);
        }

        // Exécute le code PHP contenu dans le fichier template
        ob_start();
        extract($data);
        include($path);
        $html = ob_get_clean() ?: '';

        // Remap assets to public/template so CSS/JS/images load correctly.
        $html = str_replace(
            ['href="css/', "href='css/", 'src="js/', "src='js/", 'src="image/', "src='image/"],
            ['href="/template/css/', "href='/template/css/", 'src="/template/js/', "src='/template/js/", 'src="/template/image/', "src='/template/image/"],
            $html
        );

        return $this->response
            ->setStatusCode(200)
            ->setContentType('text/html', 'UTF-8')
            ->setBody($html);
    }
}

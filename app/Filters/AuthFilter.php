<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('is_logged_in')) {
            $accept = (string) $request->getHeaderLine('Accept');
            $isJsonRequest =
                str_contains($accept, 'application/json') ||
                $request->isAJAX() ||
                (string) $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest';

            if (!$isJsonRequest) {
                // Page HTML => redirection vers la page connexion
                return redirect()->to('/connexion');
            }

            // Requête API => JSON 401
            $response = service('response');
            return $response->setStatusCode(401)->setJSON([
                'success' => false,
                'error'   => 'Non autorisé. Veuillez vous connecter 4.'
            ]);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Pas d'action post-requête nécessaire
    }
}

<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(
        RequestInterface $request,
        $arguments = null
    )
    {
        if (!session()->get('is_logged_in')) {
            if ($request->isAJAX()) {
                return service('response')->setStatusCode(401)->setJSON([
                    'success' => false,
                    'message' => 'Utilisateur non connecte',
                ]);
            }

            return redirect()->to('/');
        }

        if (session()->get('role') !== 'admin') {
            if ($request->isAJAX()) {
                return service('response')->setStatusCode(403)->setJSON([
                    'success' => false,
                    'message' => 'Acces refuse',
                ]);
            }

            return redirect()->to('/');
        }
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
    }
}
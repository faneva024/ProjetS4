<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function sendSuccess(string $message = "", array $data = [], int $statusCode = 200)
    {
        return $this->response->setStatusCode($statusCode)->setJSON([
            'success' => true,
            'message' => $message,
            'data'    => $data
        ]);
    }

    protected function sendError(string $error, int $statusCode = 400)
    {
        return $this->response->setStatusCode($statusCode)->setJSON([
            'success' => false,
            'error'   => $error
        ]);
    }
}
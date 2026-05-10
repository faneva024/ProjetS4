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

    protected function sendError(string|array $error, int $statusCode = 400)
    {
        $payload = [
            'success' => false,
        ];

        if (is_array($error)) {
            $payload['error'] = 'Validation error';
            $payload['errors'] = $error;
        } else {
            $payload['error'] = $error;
        }

        return $this->response->setStatusCode($statusCode)->setJSON([
            ...$payload,
        ]);
    }
}
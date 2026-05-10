<?php

namespace App\Services;

use App\Models\RegimeModel;

class RegimesService
{
    /**
     * @return array{regimes: array<int, array<string, mixed>>}
     */
    public function getRegimesData(): array
    {
        $model = new RegimeModel();
        $regimes = $model->findAll();

        return [
            'regimes' => $regimes ?? [],
        ];
    }
}

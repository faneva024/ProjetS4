<?php

namespace App\Services;

class EstimationService
{
    public function estimateDuration(float $poidsActuel, float $poidsCible, float $deltaMensuel = 3.0): array
    {
        $diff = abs($poidsActuel - $poidsCible);
        $dureeMois = ceil($diff / $deltaMensuel);
        
        $dateFinale = new \DateTime();
        $dateFinale->modify("+$dureeMois months");

        return [
            'delta_poids' => round($diff, 2),
            'rythme_mensuel' => $deltaMensuel,
            'duree_estimee_mois' => $dureeMois,
            'date_finale_estimee' => $dateFinale->format('Y-m-d')
        ];
    }
}
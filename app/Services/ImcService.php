<?php

namespace App\Services;

class ImcService
{
    public function calculateIMC(float $poidsKg, float $tailleCm): float
    {
        $tailleM = $tailleCm / 100;
        if ($tailleM <= 0) return 0;
        return round($poidsKg / ($tailleM * $tailleM), 2);
    }

    public function getIMCCategory(float $imc): string
    {
        if ($imc < 18.5) return 'maigreur';
        if ($imc <= 25) return 'normal';
        if ($imc <= 30) return 'surpoids';
        return 'obesite';
    }

    public function calculateIdealWeight(float $tailleCm): float
    {
        // Formule de Lorentz simplifiée pour objectif neutre
        $tailleM = $tailleCm / 100;
        return round(22 * ($tailleM * $tailleM), 2); // Vise un IMC de 22
    }

    public function calculateHealthProgress(float $poidsActuel, float $poidsInitial, float $poidsCible): float
    {
        if ($poidsInitial == $poidsCible) return 100;
        $totalAPerdre = abs($poidsInitial - $poidsCible);
        $perdu = abs($poidsInitial - $poidsActuel);
        $pourcentage = ($perdu / $totalAPerdre) * 100;
        
        return round(min(max($pourcentage, 0), 100), 2);
    }
}
<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfController extends BaseController
{
    public function downloadRapport()
    {
        $userId = session()->get('user_id');
        if (!$userId) return redirect()->to('/idfit_connexion.php');

        // 1. Récupération des données (ex: via un Service)
        $data = [
            'title' => 'Mon Rapport Santé IdFit',
            'date'  => date('d/m/Y'),
            // Ajoute ici les données de l'utilisateur (poids, imc, etc.)
        ];

        // 2. Chargement du HTML depuis la vue
        $html = view('pdf/rapport', $data);

        // 3. Configuration de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 4. Envoi au navigateur
        return $dompdf->stream("rapport_idfit.pdf", ["Attachment" => true]);
    }
}
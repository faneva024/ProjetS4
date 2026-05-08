<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use Dompdf\Dompdf;
use App\Models\UserModel;
use App\Services\ImcService;

class PdfController extends Controller
{
    public function downloadRapport()
    {
        if (!session()->get('is_logged_in')) return redirect()->to('/api/login');

        $userId = session()->get('user_id');
        $user = (new UserModel())->find($userId);
        $imcService = new ImcService();
        $imc = $imcService->calculateIMC($user['poids'], $user['taille']);

        $data = [
            'user' => $user,
            'imc' => $imc,
            'categorie' => $imcService->getIMCCategory($imc),
            'poids_ideal' => $imcService->calculateIdealWeight($user['taille'])
        ];

        $html = view('pdf/rapport', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $dompdf->stream("NutriPlan_Rapport_" . $user['nom'] . ".pdf", ["Attachment" => true]);
    }
}
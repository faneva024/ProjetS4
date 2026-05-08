<?php

namespace App\Controllers;

use App\Models\PrixRegimeModel;

class PrixRegimeController extends BaseController
{
    public function create()
    {
        $model = new PrixRegimeModel();

        $model->save([
            'regime_id' => $this->request->getPost('regime_id'),
            'duree_mois' => $this->request->getPost('duree_mois'),
            'prix' => $this->request->getPost('prix')
        ]);

        return redirect()->back();
    }

    public function delete($id)
    {
        $model = new PrixRegimeModel();

        $model->delete($id);

        return redirect()->back();
    }
}
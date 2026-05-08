<?php

namespace App\Controllers;

use App\Models\SportModel;

class SportController extends BaseController
{
    public function index()
    {
        $model = new SportModel();

        $data['sports'] =
            $model->findAll();

        return view(
            'admin/sports/index',
            $data
        );
    }

    public function create()
    {
        $model = new SportModel();

        $model->save([
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'difficulte' => $this->request->getPost('difficulte'),
            'calories_brulees' => $this->request->getPost('calories_brulees'),
            'duree_min' => $this->request->getPost('duree_min'),
            'frequence_semaine' => $this->request->getPost('frequence_semaine')
        ]);

        return redirect()->back();
    }

    public function delete($id)
    {
        $model = new SportModel();

        $model->delete($id);

        return redirect()->back();
    }
}
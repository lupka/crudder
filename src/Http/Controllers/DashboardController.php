<?php

namespace Lupka\Crudder\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use Lupka\Crudder\CrudderModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $models = CrudderModel::all();
        return view('crudder::dashboard', ['models' => $models]);
    }
}

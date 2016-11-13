<?php

namespace Lupka\Crudder\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use Lupka\Crudder\CrudderModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $models = CrudderModel::all()->filter(function ($value, $key) {
            return $value->config['dashboard'];
        });
        return view('crudder::dashboard', ['models' => $models]);
    }
}

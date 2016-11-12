<?php

namespace Lupka\Crudder\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $models = [];
        return view('crudder::dashboard', ['models' => $models]);
    }
}

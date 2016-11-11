<?php

namespace Lupka\Crudder\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return 'dashboard';
    }
}

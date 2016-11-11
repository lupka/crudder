<?php

namespace Lupka\Crudder;

use Illuminate\Contracts\Routing\Registrar as Router;

class Crudder
{
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function routes()
    {
        $this->router->get('dashboard', ['as' => 'crudder_dashboard', 'uses' => '\Lupka\Crudder\Http\Controllers\DashboardController@index']);
        $this->router->get('create/{tableName}', ['as' => 'crudder_create', 'uses' => '\Lupka\Crudder\Http\Controllers\CrudController@create']);
        $this->router->post('create/{tableName}', ['as' => 'crudder_create', 'uses' => '\Lupka\Crudder\Http\Controllers\CrudController@store']);
        $this->router->get('edit/{tableName}/{id}', ['as' => 'crudder_edit', 'uses' => '\Lupka\Crudder\Http\Controllers\CrudController@edit']);
    }
}

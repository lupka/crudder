<?php

namespace Lupka\Crudder;

use Lupka\Crudder\Fields\Factory as FieldFactory;
use Illuminate\Contracts\Routing\Registrar as Router;

class Crudder
{
    public function __construct(Router $router, FieldFactory $fieldFactory)
    {
        $this->router = $router;
        $this->fieldFactory = $fieldFactory;
    }

    public function routes()
    {
        $this->router->get('dashboard', ['as' => 'crudder_dashboard', 'uses' => '\Lupka\Crudder\Http\Controllers\DashboardController@index']);
        $this->router->get('index/{tableName}', ['as' => 'crudder_index', 'uses' => '\Lupka\Crudder\Http\Controllers\CrudController@index']);
        $this->router->get('create/{tableName}', ['as' => 'crudder_create', 'uses' => '\Lupka\Crudder\Http\Controllers\CrudController@create']);
        $this->router->post('create/{tableName}', ['as' => 'crudder_create', 'uses' => '\Lupka\Crudder\Http\Controllers\CrudController@store']);
        $this->router->get('edit/{tableName}/{id}', ['as' => 'crudder_edit', 'uses' => '\Lupka\Crudder\Http\Controllers\CrudController@edit']);
        $this->router->post('edit/{tableName}/{id}', ['as' => 'crudder_edit', 'uses' => '\Lupka\Crudder\Http\Controllers\CrudController@update']);
    }

    // Field type management, is this the best way to do this??
    public function addFieldType($key, $className)
    {
        $this->fieldFactory->addType($key, $className);
    }

    public function getFieldTypes()
    {
        return $this->fieldFactory->getTypes();
    }
}

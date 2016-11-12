<?php

namespace Lupka\Crudder\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use Lupka\Crudder\CrudderModel;

class CrudController extends BaseController
{
    public function index()
    {

    }

    public function create($tableName)
    {
        $crudderModel = CrudderModel::fromTableName($tableName);
        return view('crudder::create', ['crudderModel' => $crudderModel]);
    }

    public function store(Request $request, $tableName)
    {
        $crudderModel = CrudderModel::fromTableName($tableName);
        $object = $crudderModel->dispenseModel();

        foreach($crudderModel->fields as $field){
          $value = $request->input($field->fieldName);
          $object->{$field->fieldName} = $field->valueDefault($value);
        }

        $object->save();

        return \Redirect::route('crudder_dashboard');
    }

    public function edit($tableName, $id)
    {
        $crudderModel = CrudderModel::fromTableName($tableName);

        $object = $crudderModel->loadModel($id);

        dd($object);

        //return view('crudder::create', ['crudderModel' => $crudderModel]);
    }

}

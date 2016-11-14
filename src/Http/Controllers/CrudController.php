<?php

namespace Lupka\Crudder\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use Lupka\Crudder\CrudderModel;

class CrudController extends BaseController
{
    public function index($tableName)
    {
        $crudderModel = CrudderModel::fromTableName($tableName);
        $rows = $crudderModel->query()->get();
        return view('crudder::index', ['crudderModel' => $crudderModel, 'rows' => $rows]);
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

        return view('crudder::edit', ['crudderModel' => $crudderModel, 'object' => $object]);
    }

    public function update($tableName, $id, Request $request)
    {
        $crudderModel = CrudderModel::fromTableName($tableName);
        $object = $crudderModel->loadModel($id);

        foreach($crudderModel->fields as $field){
            $value = $request->input($field->fieldName);
            $object->{$field->fieldName} = $field->valueDefault($value);
        }

        $object->save();

        return redirect($crudderModel->editUrl($object));
    }

}

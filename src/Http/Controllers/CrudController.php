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

    public function show($tableName, $id)
    {
        $crudderModel = CrudderModel::fromTableName($tableName);
        $model = $crudderModel->loadModel($id);

        return view('crudder::view', ['crudderModel' => $crudderModel, 'model' => $model]);
    }

    public function create($tableName)
    {
        $crudderModel = CrudderModel::fromTableName($tableName);
        if(!$this->permissionCheck($crudderModel, 'create')) return redirect($crudderModel->indexUrl());
        return view('crudder::create', ['crudderModel' => $crudderModel]);
    }

    public function store(Request $request, $tableName)
    {
        $crudderModel = CrudderModel::fromTableName($tableName);
        if(!$this->permissionCheck($crudderModel, 'create')) return redirect($crudderModel->indexUrl());
        $model = $crudderModel->dispenseModel();

        foreach($crudderModel->fields as $field){
            if ($field->hasValue($request)){
                $model->{$field->fieldName} = $field->processInputValue($request, $field->fieldName);
            }
        }

        $model->save();

        $this->flash($crudderModel->getConfig('name').' created!', 'success');

        return \Redirect::route('crudder_dashboard');
    }

    public function edit($tableName, $id)
    {
        $crudderModel = CrudderModel::fromTableName($tableName);
        if(!$this->permissionCheck($crudderModel, 'update')) return redirect($crudderModel->indexUrl());
        $model = $crudderModel->loadModel($id);

        return view('crudder::edit', ['crudderModel' => $crudderModel, 'model' => $model]);
    }

    public function update($tableName, $id, Request $request)
    {
        $crudderModel = CrudderModel::fromTableName($tableName);
        if(!$this->permissionCheck($crudderModel, 'update')) return redirect($crudderModel->indexUrl());
        $model = $crudderModel->loadModel($id);

        foreach($crudderModel->fields as $field){
            if ($field->hasValue($request)){
                $model->{$field->fieldName} = $field->processInputValue($request, $field->fieldName);
            }
        }

        $model->save();

        $this->flash($crudderModel->getConfig('name').' updated!', 'success');

        return redirect($crudderModel->editUrl($model));
    }

    public function delete($tableName, $id)
    {
        $crudderModel = CrudderModel::fromTableName($tableName);
        if(!$this->permissionCheck($crudderModel, 'delete')) return redirect($crudderModel->indexUrl());
        $model = $crudderModel->loadModel($id);
        $model->delete();
        $this->flash($crudderModel->getConfig('name').' deleted.', 'info');
        return redirect($crudderModel->indexUrl());
    }

    private function flash($message, $type = 'info')
    {
        session()->flash('alert.message', $message);
        session()->flash('alert.type', $type);
    }

    private function permissionCheck($crudderModel, $action)
    {
        if($crudderModel->actionEnabled($action)){
            return true;
        }
        else{
            $this->flash('You do not have permission to perform this action.', 'warning');
            return false;
        }
    }
}

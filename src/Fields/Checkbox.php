<?php

namespace Lupka\Crudder\Fields;

use Illuminate\Http\Request;

class Checkbox extends Field
{

    public function typeName()
    {
        return 'Checkbox';
    }

    public function renderFormField($model = null)
    {
        return view('crudder::fields.form.checkbox', ['fieldName' => $this->fieldName, 'field' => $this, 'model' => $model]);
    }

    public function processInputValue(Request $request, $key)
    {
        if($request->get($key) === null){
            return false;
        }
        else{
            return $request->get($key);
        }
    }
}

<?php

namespace Lupka\Crudder\Fields;

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

    public function valueDefault($value)
    {
        if($value === null){
            return false;
        }
        else{
            return $value;
        }
    }
}

<?php

namespace Lupka\Crudder\Fields;

class Boolean extends Field
{

    public function typeName()
    {
        return 'Boolean';
    }

    public function renderFormField()
    {
        return view('crudder::fields.form.boolean', ['fieldName' => $this->fieldName, 'field' => $this]);
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

<?php

namespace Lupka\Crudder\Fields;

class Select extends Field
{

    public function typeName()
    {
        return 'Select';
    }

    public function renderFormField($model = null)
    {
        return view('crudder::fields.form.select', ['fieldName' => $this->fieldName, 'field' => $this, 'model' => $model]);
    }

}

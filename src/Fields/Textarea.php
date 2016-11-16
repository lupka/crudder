<?php

namespace Lupka\Crudder\Fields;

class Textarea extends Field
{

    public function typeName()
    {
        return 'Textarea';
    }

    public function renderFormField($model = null)
    {
        return view('crudder::fields.form.textarea', ['fieldName' => $this->fieldName, 'field' => $this, 'model' => $model]);
    }

}

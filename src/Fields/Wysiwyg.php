<?php

namespace Lupka\Crudder\Fields;

class Wysiwyg extends Field
{

    public function typeName()
    {
        return 'Wysiwyg';
    }

    public function renderFormField($model = null)
    {
        return view('crudder::fields.form.wysiwyg', ['fieldName' => $this->fieldName, 'field' => $this, 'model' => $model]);
    }

}

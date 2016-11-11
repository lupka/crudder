<?php

namespace Lupka\Crudder\Fields;

class Text extends Field
{

    public function typeName()
    {
        return 'Text';
    }

    public function renderFormField()
    {
        return view('crudder::fields.form.text', ['fieldName' => $this->fieldName, 'field' => $this]);
    }

}

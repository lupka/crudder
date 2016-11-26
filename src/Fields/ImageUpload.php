<?php

namespace Lupka\Crudder\Fields;

use Illuminate\Http\Request;

class ImageUpload extends FileUpload
{

    public function typeName()
    {
        return 'Image Upload';
    }

    public function renderFormField($model = null)
    {
        return view('crudder::fields.form.image_upload', ['fieldName' => $this->fieldName, 'field' => $this, 'model' => $model]);
    }

    public function displayValue($model)
    {
        return '<img src="'.$this->getConfig('public_path').'/'.$model->{$this->fieldName}.'" style="max-width:100px; max-height: 100px;">';
    }

}

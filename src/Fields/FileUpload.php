<?php

namespace Lupka\Crudder\Fields;

use Illuminate\Http\Request;

class FileUpload extends Field
{

    public function typeName()
    {
        return 'File Upload';
    }

    public function renderFormField($model = null)
    {
        return view('crudder::fields.form.file_upload', ['fieldName' => $this->fieldName, 'field' => $this, 'model' => $model]);
    }

    /**
     * Form Attribute Registration
     */
    public function formAttributes()
    {
        return [
            'enctype' => 'multipart/form-data',
        ];
    }

    /**
     * Value output and filtering
     */
    public function processInputValue(Request $request, $key)
    {
        // doing upload here and returning filename
        $val = $request->$key->storeAs($this->getConfig('upload_directory', 'public/images'), $request->$key->getClientOriginalName());
        dd($val);
        return $key;
    }

}

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
     public function hasValue(Request $request)
     {
         // using hasFile() here instead of has()
         return $request->hasFile($this->fieldName);
     }

    public function processInputValue(Request $request, $key)
    {
        $filePath = $request->$key->storeAs($this->getConfig('upload_directory'), $request->$key->getClientOriginalName());
        return basename($filePath); // not sure if this is the best way to do this but it'll work for now
    }

}

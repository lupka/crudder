<?php

namespace Lupka\Crudder\Fields\Relationships;

use Lupka\Crudder\Fields\Field as Field;

class BelongsTo extends Field
{
    protected $relation;

    public function __construct($fieldName, $className, $config)
    {
        parent::__construct($fieldName, $className, $config);
        $this->relation = $config['relation'];
    }

    public function typeName()
    {
        return 'Belongs To';
    }

    public function renderFormField()
    {
        //dd($this->relation);
        $options = $this->relation->getRelated()->get()->lists('name', 'id'); // TODO: get field name here for dropdown name
        return view('crudder::fields.form.belongs_to', ['fieldName' => $this->fieldName, 'field' => $this, 'options' => $options]);
    }

}

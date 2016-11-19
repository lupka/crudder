<?php

namespace Lupka\Crudder\Fields;

class Factory{

    protected $types = [
        // Basic field types
        'text' => Text::class,
        'checkbox' => Checkbox::class,
        'textarea' => Textarea::class,
        'select' => Select::class,
        'wysiwyg' => Wysiwyg::class,

        // Eloquent Relationships
        'belongsTo' => Relationships\BelongsTo::class,
    ];

    public function dispenseField($type, $fieldName, $className, $config = [])
    {
        // TODO: refactor $types to collections
        return new $this->types[$type]($fieldName, $className, $config);
    }

    public function typeNameArray()
    {
        // TODO: refactor $types to collections
        $array = [];
        foreach($this->types as $typeKey => $type){
            $array[$typeKey] = (new $type)->name();
        }
        return $array;
    }

    public function addType($key, $className)
    {
        $this->types[$key] = $className;
    }

    public function getTypes()
    {
        return $this->types;
    }

}

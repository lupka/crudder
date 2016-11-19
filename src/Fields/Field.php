<?php

namespace Lupka\Crudder\Fields;

class Field
{
    public $fieldName;
    public $className;
    public $value;
    public $config;

    public function __construct($className, $fieldName, $config = [])
    {
        $this->className = $className;
        $this->fieldName = $fieldName;
        $this->parseConfig();
    }

    public function typeName()
    {
        return 'No Name Given';
    }

    public function valueDefault($value)
    {
        return $value;
    }

    /**
     * General Configuration (names, etc)
     */
    protected function parseConfig()
    {
        $defaults = [
            'label' => $this->defaultLabel(),
        ];
        $this->config = array_merge($defaults, config('crudder.models.'.$this->className.'.fields.'.$this->fieldName, []));
    }

    public function getConfig($key)
    {
        return isset($this->config[$key]) ? $this->config[$key] : '';
    }

    public function defaultLabel()
    {
        return ucwords(str_singular(str_replace('_', ' ', $this->fieldName)));
    }

    /**
     * Script Registration
     */
    public function scripts()
    {
        return [];
    }

}

<?php

namespace Lupka\Crudder;

use Lupka\Crudder\Fields\Factory as FieldFactory;
use Lupka\Crudder\RelationshipFinder;

use Illuminate\Support\Collection;

class CrudderModel
{
    public $className;
    public $tableName;
    public $config;
    public $fields = [];
    protected $fieldFactory;
    protected $relationshipFinder;

    /**
     * Constructor
     */
    public function __construct($className)
    {
        $this->fieldFactory = new FieldFactory();
        $this->relationshipFinder = new RelationshipFinder();
        $this->className = $className;
        $this->tableName = $this->getTableName();
        $this->generateFields();
        $this->generateRelationshipFields();
        $this->parseModelConfig();
    }

    /**
     * Model retreival
     */
    // returns all models in collection
    public static function get()
    {
        $configModels = collect(config('crudder.models'));
        return $configModels->map(function($item, $key){
            return new self($key);
        });
    }

    public static function all()
    {
        $configModels = config('crudder.models');
        $models = [];
        foreach($configModels as $className => $options){
            $models[] = new self($className);
        }
        return collect($models);
    }

    public static function fromTableName($tableName)
    {
        $loadedModels = self::all();
        if($model = $loadedModels->where('tableName', $tableName)->first()){
            return $model;
        }
        else{
            // throw error?
        }
    }

    /**
     * General Configuration (names, etc)
     */
    protected function parseModelConfig()
    {
        $defaultModelConfig = [
            'name' => $this->defaultName(),
            'name_plural' => $this->defaultNamePlural(),
            'dashboard_name_field' => $this->defaultDashboardNameField()
        ];
        $this->config = array_merge($defaultModelConfig, config('crudder.models.'.$this->className));
    }

    public function getConfig($key)
    {
        return isset($this->config[$key]) ? $this->config[$key] : '';
    }

    public function defaultName()
    {
        return ucwords(str_singular(str_replace('_', ' ', $this->tableName)));
    }

    public function defaultNamePlural()
    {
        return str_plural($this->defaultName());
    }

    public function defaultDashboardNameField()
    {
        return $this->fields->first()->fieldName;
    }

    /**
     * Fields
     */
    protected function generateFields()
    {
        $fields = $this->getFieldsConfig();
        $this->fields = new Collection();
        foreach($fields as $fieldName => $field){

            // ignoring some defaults
            // TODO: move this to config
            if(in_array($fieldName, ['id','created_at','updated_at'])){
                continue;
            }

            $this->fields[] = $this->fieldFactory->dispenseField($this->getFieldSuggestion($field['fieldType']), $this->className, $fieldName);
        }
    }

    public function getFieldSuggestion($fieldType)
    {
        if(in_array($fieldType,['string'])){
            return 'text';
        }
        elseif(in_array($fieldType,['boolean'])){
            return 'boolean';
        }
        else{
            return 'text';
        }
    }

    public function getFieldsConfig()
    {
        $config = [];
        $fields = \Schema::getColumnListing($this->getTableName());
        foreach($fields as $field){
            $config[$field] = [
                'fieldType' => self::getFieldType($this->getTableName(), $field)
            ];
        }
        return $config;
    }


    /**
     * Relationship Fields
     */
    protected function generateRelationshipFields()
    {
        $relationships = $this->relationshipFinder->getPropertiesFromMethods($this->dispenseModel());
        foreach($relationships as $relationship){
            $this->fields[] = $this->fieldFactory->dispenseField($relationship['type'], $this->className, $relationship['fieldName'], ['relation' => $relationship['relationObj']]);
        }
    }

    /**
     * Loading Objects
     */
     public function dispenseModel()
     {
         return new $this->className;
     }
     public function query()
     {
         $className = $this->className;
         return $className::query();
     }
     public function loadModel($id)
     {
         return $this->query()->find($id);
     }
     public function dashboardItems()
     {
         return $this->query()->limit(5)->get();
     }

    /**
     * Utility Methods
     */
    public static function getFieldType($tableName, $fieldName)
    {
        return \DB::connection()->getDoctrineColumn($tableName, $fieldName)->getType()->getName();
    }

    public function getTableName()
    {
        return (new $this->className)->getTable();
    }

    /**
     * URLs
     */
    public function createUrl()
    {
        return route('crudder_create', ['tableName' => $this->getTableName()]);
    }

}

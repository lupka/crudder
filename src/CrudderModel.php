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
        return self::get();
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
            'dashboard_name_field' => $this->defaultDashboardNameField(),
            'dashboard' => true,
        ];
        $this->config = array_merge($defaultModelConfig, config('crudder.models.'.$this->className));

        // name_plural is separate so it can be derived from default OR manually set
        if(!isset($this->config['name_plural'])) $this->config['name_plural'] = str_plural($this->config['name']);
    }

    public function getConfig($key)
    {
        return isset($this->config[$key]) ? $this->config[$key] : '';
    }

    public function defaultName()
    {
        return ucwords(str_singular(str_replace('_', ' ', $this->tableName)));
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
        foreach($fields as $fieldName => $field)
        {
            if(!in_array($fieldName, config('crudder.models.'.$this->className.'.hidden_fields', ['id','created_at','updated_at']))){
                $this->fields[] = $this->fieldFactory->dispenseField($this->getFieldSuggestion($field['fieldType']), $this->className, $fieldName);
            }
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
    public function indexUrl()
    {
        return route('crudder_index', ['tableName' => $this->getTableName()]);
    }
    public function createUrl()
    {
        return route('crudder_create', ['tableName' => $this->getTableName()]);
    }
    public function editUrl($model)
    {
        return route('crudder_edit', ['tableName' => $this->getTableName(), 'id' => $model->id]);
    }
    public function deleteUrl($model)
    {
        return route('crudder_delete', ['tableName' => $this->getTableName(), 'id' => $model->id]);
    }

}

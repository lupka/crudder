<?php
/**
 * Borrowed this from here: https://github.com/barryvdh/laravel-ide-helper/blob/master/src/Console/ModelsCommand.php
 * via: http://stackoverflow.com/questions/20334843/get-all-relationships-from-eloquent-model
 */

namespace Lupka\Crudder;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\ClassLoader\ClassMapGenerator;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Context;
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\DocBlock\Serializer as DocBlockSerializer;


class RelationshipFinder
{
    protected $relationships = array();

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function getPropertiesFromMethods($model)
    {
        $methods = get_class_methods($model);
        if ($methods) {
            foreach ($methods as $method) {

                if (Str::startsWith($method, 'get') && Str::endsWith($method, 'Attribute') && $method !== 'getAttribute') {

                } elseif (Str::startsWith($method, 'set') && Str::endsWith($method, 'Attribute') && $method !== 'setAttribute') {

                } elseif (Str::startsWith($method, 'scope') && $method !== 'scopeQuery') {

                } elseif (!method_exists('Illuminate\Database\Eloquent\Model', $method) && !Str::startsWith($method, 'get')) {

                    //Use reflection to inspect the code, based on Illuminate/Support/SerializableClosure.php
                    $reflection = new \ReflectionMethod($model, $method);

                    $file = new \SplFileObject($reflection->getFileName());
                    $file->seek($reflection->getStartLine() - 1);

                    $code = '';
                    while ($file->key() < $reflection->getEndLine()) {
                        $code .= $file->current();
                        $file->next();
                    }
                    $code = trim(preg_replace('/\s\s+/', '', $code));
                    $begin = strpos($code, 'function(');
                    $code = substr($code, $begin, strrpos($code, '}') - $begin + 1);

                    foreach (array(
                               'hasMany',
                               'belongsToMany',
                               'hasOne',
                               'belongsTo',
                               'morphOne',
                               'morphTo',
                               'morphMany',
                               'morphToMany'
                             ) as $relation) {
                        $search = '$this->' . $relation . '(';
                        if ($pos = stripos($code, $search)) {

                            //Resolve the relation's model to a Relation object.
                            $relationObj = $model->$method();

                            if ($relationObj instanceof Relation) {
                                $relatedModel = '\\' . get_class($relationObj->getRelated());

                                if (in_array($relation, ['belongsToMany', 'hasMany', 'morphMany', 'morphToMany'])) {
                                    //Collection or array of models (because Collection is Arrayable)
                                    $this->setRelationship($method, $relation, $this->getCollectionClass($relatedModel) . '|' . $relatedModel . '[]', $relationObj);
                                } elseif ($relation === "morphTo") {
                                    // Model isn't specified because relation is polymorphic
                                    $this->setRelationship($method, $relation, '\Illuminate\Database\Eloquent\Model|\Eloquent', $relationObj);
                                } else {
                                    //Single model is returned
                                    $this->setRelationship($method, $relation, $relatedModel, $relationObj);
                                }
                            }
                        }
                    }
                }
            }

            return $this->relationships;
        }
    }

    protected function setRelationship($name, $type, $model, $relationObj){
        $this->relationships[$name] = [
            'fieldName' => $name,
            'type' => $type,
            'model' => $model,
            'relationObj' => $relationObj,
        ];
    }

}

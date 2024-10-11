<?php

/***
 * Support to indexing a single record
 * Can be use like : app('es-makeindex')->initialize($modelObj)->execute();
 */

namespace Dev\ElasticsearchLaravel\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\LazyCollection;

use DateTime;
use Exception;
use Throwable;

use Basemkhirat\Elasticsearch\Facades\ES;

use Dev\Media\Models\MediaFile;
use Dev\Base\Enums\BaseStatusEnum;

class ElasticsearchService
{

    /**
     * Field DateTime
     *
     * @var array
     */
    const FDATETIME = [
        'created_at',
        'updated_at',
        'published_up',
        'published_down',
        'expired_at'
    ];

    /**
     * Field Salary
     */
    const FSALARY = [
        'fromsalary',
        'tosalary'
    ];

    private $entity; // model class
    private $entityName;
    private $entityClass;
    private $entityNamespace;

    private $entities;

    /**
     *
     * @var array
     */
    private $params = []; // elasticsearch

    /**
     *
     * @var array
     */
    private $body = []; // elasticsearch

    /**
     *
     * @var string
     */
    private $action; // elasticsearch

    /**
     *
     * @var string
     */
    private $prefix; // prefix of indices

    /**
     *
     * @var array
     */
    private $config; // data of es.php

    /**
     *
     * @var array
     */
    private $indices; // indices

    /**
     * ElasticsearchService Constructor
     *
     * @param array $config
     */

    private $logger = 'elastic-makeindex';

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Check instance of DateTime
     *
     * @param
     *            $value
     * @return bool
     */
    private function checkTypeofDateTime($value)
    {
        return $value instanceof DateTime;
    }

    /**
     * Check field DateTime
     *
     * @param string $field
     * @return bool
     */
    private function checkFieldDatetime(string $field)
    {
        return in_array($field, self::FDATETIME);
    }

    /**
     * Check Field Salary
     *
     * @param string $field
     * @return bool
     */
    private function checkFieldSalary(string $field)
    {
        return in_array($field, self::FSALARY);
    }

    /**
     * Check field relation is belongTo
     *
     * @param object $object
     * @return bool
     */
    private function isBelongTo($object)
    {
        return $object instanceof BelongsTo;
    }

    /**
     * Check field relation is belongToMany
     *
     * @param object $object
     * @return bool
     */
    private function isBelongToMany($object)
    {
        return $object instanceof BelongsToMany;
    }

    /**
     * Check field Media
     *
     * @param object $object
     * @return bool
     */
    private function isMedia($object)
    {
        return $object instanceof MediaFile;
    }

    private function getIndexName()
    {
        return strtolower("{$this->prefix}{$this->getEntityName()}");
    }
    /**
     * Get entity name
     *
     * @param Model $entity
     * @return string
     */
    private function getEntityName()
    {
        try {
            $this->entityClass = get_class($this->entity);
            $collection = Str::of($this->getEntityClass())->explode("\\");

            if ($collection instanceof Collection) {
                $this->entityName = $collection->last(); // array_values(array_slice(explode('\\', $this->entityClass), -1))[0]; // Post
            }

            return $this->entityName;
        } catch (Throwable $th) {
            throw $th;
        }
    }
    /**
     * Get entity name
     *
     * @param Model $entity
     * @return string
     */
    private function getEntityClass()
    {
        try {
            return $this->entityClass = get_class($this->entity);
        } catch (Throwable $th) {
            throw $th;
        }
    }
    /**
     * Get entity namespace
     *
     * @param Model $entity
     * @return string
     */
    private function getEntityNamespace()
    {
        try {
            $this->entityNamespace = null;
            $entityClass = get_class($this->entity);
            $collection = Str::of($entityClass)->explode("\\");

            if ($collection instanceof Collection) {
                $this->entityNamespace = $collection->slice(0, -1)->implode('\\'); // $this->argument('namespace');
            }

            return $this->entityNamespace;
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get Entity ID
     *
     * @param Model $object
     */
    private function getEntityId()
    {
        return $this->entity->id;
    }

    /**
     * Get Time from field
     *
     * @param DateTime $value
     * @return int
     */
    private function getTimestamp($value)
    {
        try {
            return Carbon::parse($value)->getTimestamp();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function setEntity($entity)
    {

        $this->entity = $entity;

        return $this;
    }

    private function setParams()
    {
        $this->params["body"][$this->getEntityId()] = $this->body;
    }

    /**
     * get param option
     *
     * @return array
     */
    private function getParams()
    {
        try {
            return $this->params;
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * initialize action make index
     *
     * @param Model $entity
     * @param string $action,
     *            default index
     * @return this
     */
    public function initialize($action = 'index')
    {
        try {
            $this->indices = Arr::get($this->config, "indices", []);

            $this->prefix = strtolower(Str::slug(env(
                'APP_NAME',
                'pkhl'
            ), '_') . "_"); // prefix of indices

            $this->logger = apps_logger($this->logger);

            $this->action = $action;

            return $this;
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * execute make index entity
     *
     * @return void
     */
    public function bulk($entities)
    {
        try {
            if (is_object($entities) && $entities instanceof Model) {
                $this->entities[] = $entities;
            } else {
                $this->entities = $entities; // array [obj, obj, obj]
            }


            // $params["body"][$entityId] = [
            //     $actionType => [
            //         '_index' => $config['index_name'], // master-db
            //         '_type' => "JmsJob", // JmsJob for example
            //         '_id' => $entityId
            //     ]
            // ];
            $run = 0;
            foreach ($this->entities as $entity):
                $this->setEntity($entity);

                if ($entity instanceof Model):

                else:
                    throw new Exception('Entity must be an instance of \Illuminate\Database\Eloquent\Model');
                endif;

                $settings = Arr::get($this->indices, $this->getIndexName(), []);
                if (!empty($settings)):
                    $this->setBody();
                endif;

                if ($run++ % 100 == 0):
                    $this->execute();
                endif;
            endforeach;

            $this->execute(); // indexing the remaining records

        } catch (Throwable $th) {
            throw $th;
        }
    }

    /*
     * |-------------------------------------------------------------------------------------------------------------------
     * | Elasticsearch Relationship Model
     * |-------------------------------------------------------------------------------------------------------------------
     * |
     * | As an alternative to inner objects, Elasticsearch provides the concept of " nested types". Nested documents
     * | look identical to inner objects at the document level, but provide the functionality we were missing above (as
     * | well as some limitations).
     * |
     * | https://www.elastic.co/blog/managing-relations-inside-elasticsearch
     * |
     * | Example Data: [JmsJob=>[job=>id,name,user=>[it is sub entity]]]
    */
    public function setBody()
    {
        try {
            $entityProperty = Arr::get($this->indices, "{$this->getIndexName()}.makeindex.models.{$this->getEntityClass()}", false);
            if ($entityProperty):
                $this->loopProperty($entityProperty);
            endif;

            $this->setParams();

            return $this; // must be
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * make index es
     *
     * @return void
     */
    public function execute()
    {
        $params = $this->getParams();

        if (array_key_exists("body", $params)) {
            $responses = ES::index("{$this->getIndexName()}")->bulk($params['body']);
            if ($responses->errors) {
                Log::channel($this->logger)->error($responses->errors, [
                    "entities" => json_encode($responses->items)
                ]);
                throw ValidationException::withMessages([json_encode($responses->items)]);
            } else {
                // success, and destroy the old bulk request
                $this->params = [];
            }
        } else {
            throw new Exception('Param must have "body"');
        }
    }

    /**
     * Loop entity property
     *
     * @return void
     */
    private function loopProperty($entityProperty)
    {
        try {
            foreach ($entityProperty as $nestedKey => $nested) {
                if (is_string($nested)) {
                    if ($this->entity->{$nested})
                        $this->setBodyForEntityWhenString($nested);
                    else
                        $this->body[$nested] = null;
                } elseif (is_array($nested)) {
                    $this->setBodyForEntityWhenArray($nestedKey, $nested);
                } else {
                    throw new Exception("Elasticsearch configuration misses the property '{$this->getEntityName()}'");
                }
            }
        } catch (Throwable $th) {
            throw $th;
        }
    }
    /**
     * Loop Relation
     *
     * @return array
     */
    private function loopRelation($collection, $nestedKey, $nested)
    {
        try {
            $nestData = [];
            foreach ($nested as $f) :
                if (is_array($f)):
                # code... cần sử dụng đệ quy để kiểm tra sâu bên trong
                else :
                    $dataValue = $collection->{$f};
                    if ($this->entity->$nestedKey == null) :
                        $nestData = null;
                    // elseif ($dataValue instanceof BaseStatusEnum) :
                    //     $this->body[$nested] = $dataValue->getValue();
                    elseif ($this->isMedia($dataValue)) :
                        $nestData[$f] = $dataValue->url;
                    elseif ($this->checkTypeofDateTime($dataValue)) :
                        $nestData[$f] = $this->getTimestamp($dataValue);
                    else :
                        $nestData[$f] = $dataValue;
                    endif;

                    if ($this->checkFieldSalary($f)) :
                        $nestData[$f] = (int) $dataValue;
                    endif;
                endif;
            endforeach;

            return $nestData;
        } catch (Throwable $th) {
            throw $th;
        }
    }
    /**
     * Loop relation Many to Many
     */
    private function loopRelationMany($collections, $nestedKey, $nested)
    {
        try {
            $nestData = [];
            if ($collections->count()):
                foreach ($collections as $key => $collection)
                    $nestData[$key] = $this->loopRelation($collection, $nestedKey, $nested);
            else:
                return null;
            endif;

            return $nestData;
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * Set body via type field is string
     *
     * @return void
     */
    private function setBodyForEntityWhenString($nested)
    {
        try {
            if ($this->checkFieldDatetime($this->entity->{$nested}) || $this->checkFieldDatetime($nested)):
                $this->body[$nested] = $this->getTimestamp($this->entity->{$nested});
            // elseif ($this->entity->{$nested} instanceof BaseStatusEnum):
            //     $this->body[$nested] = $this->entity->{$nested}->getValue();
            elseif ($this->isMedia($this->entity->{$nested})):
                $this->body[$nested] = ($this->entity->{$nested}->url);
            elseif ($this->checkFieldSalary($nested)):
                $this->body[$nested] = (int) $this->entity->{$nested};
            else:
                $this->body[$nested] = $this->entity->{$nested};
            endif;
        } catch (Throwable $th) {
            throw $th;
        }
    }
    /**
     * Set body via type field is array
     *
     * @return void
     */
    private function setBodyForEntityWhenArray($nestedKey, $nested)
    {
        try {
            $nestData = [];
            if (! method_exists($this->entity, $nestedKey)) :
                throw new Exception("The '{$nestedKey}' method does not exist in your Eloquent Model '" . get_class($this->entity));
            endif;

            if (is_null($this->entity->$nestedKey)):
                $nestData = null;
            elseif ($this->isBelongTo($this->entity->$nestedKey())) :
                $collection = $this->entity->{$nestedKey};
                $nestData = $this->loopRelation($collection, $nestedKey, $nested);
            elseif ($this->isBelongToMany($this->entity->$nestedKey())) :
                $collections = $this->entity->getRelationValue($nestedKey);
                $nestData = $this->loopRelationMany($collections, $nestedKey, $nested);
            else:
                $nestData = null;
            endif;

            $this->body[$nestedKey] = $nestData;
        } catch (Throwable $th) {
            throw $th;
        }
    }
}

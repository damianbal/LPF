<?php

namespace LPF\Framework\Database\ORM;

use LPF\Framework\Database\QueryBuilder;
use LPF\Framework\Database\DBConnectionInterface;

/**
 * Simple ORM Model class
 * Models should extend that class and change
 * modelTable class to database table name
 */
class Model extends QueryBuilder
{
    /**
     * Table name in Database
     *
     * @var string
     */
    protected static $modelTable = '';

    /**
     * Table primary key field name
     *
     * @var string
     */
    protected static $idColumn = 'id';

    /**
     * Model's data 
     *
     * @var array
     */
    protected $modelData = [];

    /**
     * Set models data
     *
     * @param array $data
     * @return void
     */
    public function set($data)
    {
        $this->modelData = $data;
    }

    /**
     * Load model by ID
     *
     * @param int $id
     * @return void
     */
    public static function load($id, DBConnectionInterface $conn)
    {
        $q = new static;
        $q->appendQuery("SELECT * FROM " . static::$modelTable);
        $q->where(static::$idColumn, '=', $id);
        return $q->first($conn);
    }

    /**
     * Save model
     *
     * @return void
     */
    public function save()
    {
        // not loaded so create new one
        if(empty($this->modelData)) {
            $this->insert(static::$modelTable, $this->modelData);
        }   
        else {
            // update existing by id
        }
    }

    /**
     * Select
     *
     * @param string $fields
     * @return Model
     */
    public static function builder($fields = '*')
    {
        $q = new static;

        return $q->select(static::$modelTable, $fields);
    }

    /**
     * Returns first model
     *
     * @param DBConnectionInterface $conn
     * @return void
     */
    public function first(DBConnectionInterface $conn)
    {
        return $this->get($conn)[0] ?? null;
    }

    /**
     * Returns array of Model
     *
     * @return array
     */     
    public function get(DBConnectionInterface $conn)
    {
        // get results as assoc array
        $results = $conn->runQuery($this->getQuery(), $this->getQueryData());

        $models = [];

        // create transfomer which will transform our data to our model
        $modelTransfomer = new ModelTransfomer(static::class);

        // transform all results into models
        foreach($results as $result) {
            $models[] = $modelTransfomer->transform($result);
        }

        return $models;
    }

    /**
     * Get models data as array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->modelData;
    }

    /**
     * Set model's data
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->modelData[$name] = $value;
    }

    /**
     * Get model's data
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->modelData[$name];
    }
}

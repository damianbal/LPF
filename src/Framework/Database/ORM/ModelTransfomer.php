<?php

namespace LPF\Framework\Database\ORM;

/**
 * Transform array to Model/class
 */
class ModelTransfomer
{
    protected $modelClass = null;

    /**
     * Construct ModelTransformer
     *
     * @param string $modelClass
     */
    public function __construct($modelClass)
    {
        $this->modelClass = $modelClass;
    }

    /**
     * Transform data to model
     *
     * @param array $data
     * @return mixed
     */
    public function transform($data = [])
    {
        $mclass = $this->modelClass;
        $model = new $mclass;
        $model->set($data);
        return $model;
    }
}

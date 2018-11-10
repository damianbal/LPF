<?php

namespace LPF\Framework\Utils;

/**
 * Basic collection class to help working with arrays
 */
class Collection
{
    public $data = [];

    /**
     * Create collection
     *
     * @param array $data
     */
    public function __construct()
    {
    }

    /**
     * Create collection
     *
     * @param array $data
     * @return Collection
     */
    public static function create($data = [])
    {
        $c = new Collection;
        $c->data = $data;
        return $c;
    }

    /**
     * Set value
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Get value
     *
     * @param string $key
     * @param string $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->data[$key] : $default;
    }

    /**
     * Remove by key
     *
     * @param string $key
     * @return void
     */
    public function remove($key)
    {
        unset($this->data[$key]);
    }

    /**
     * Check if key exists
     *
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Returns array
     *
     * @return array
     */
    public function getArray(): array
    {
        return $this->data;
    }

    /**
     * Number of elements in that collection
     *
     * @return int
     */
    public function length() 
    {
        return count($this->data);
    }
}

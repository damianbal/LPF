<?php

namespace LPF\Framework\Http;

use LPF\Framework\Utils\UploadedFile;
use LPF\Framework\App;


/**
 * Simple Request
 */
class Request
{
    protected $data = [];
    protected $method = "";

    /** @var App */
    protected $app = null;

    /**
     * Create response from $_SERVER
     *
     * @return void
     */
    public function createFromGlobals()
    {
        $this->method = $method;

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method == 'GET') {
            $this->data = $_GET;
        }

        if ($method == 'POST') {
            $this->data = $_POST;
        }
    }

    /**
     * Set instance of app
     *
     * @param App $app
     * @return void
     */
    public function setApp(App $app)
    {
        $this->app = $app;
    }

    /**
     * Retrieve uploaded file
     *
     * @param string $name
     * @return UploadedFile
     */
    public function file($name)
    {
        return new UploadedFile($this->app->getStorage(), $_FILES[$name]);
    }

    /**
     * Add data to data
     *
     * @param array $data
     * @return void
     */
    public function addData(array $data)
    {
        $this->data = array_merge($this->data, $data);
    }

    /**
     * Get request method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Check if input exists
     *
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Set input
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
     * Remove input
     *
     * @param string $key
     * @return void
     */
    public function remove($key)
    {
        unset($this->data[$key]);
    }

    /**
     * Returns value of input
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->data[$key] : $default;
    }

    /**
     * Get all input data
     *
     * @return array
     */
    public function all()
    {
        return $this->data;
    }
}

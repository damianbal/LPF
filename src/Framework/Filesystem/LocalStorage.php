<?php

namespace LPF\Framework\Filesystem;

/**
 * Simple local filesystem driver
 */
class LocalStorage implements StorageInterface
{
    protected $path = null;

    /**
     * Construct Local Storage
     *
     * @param array $config
     */
    public function __construct($config)
    {
        $this->path = $config['path'];    
    }

    public function exists($path)
    {
        return file_exists($this->path . $path);
    }

    public function read($path)
    {
        if(!$this->exists($path)) return false;

        return file_get_contents($this->path . $path);
    }

    public function write($path, $data)
    {
        file_put_contents($this->path . $path, $data);
    }
}

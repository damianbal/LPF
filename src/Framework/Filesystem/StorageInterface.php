<?php

namespace LPF\Framework\Filesystem;

/**
 * Storage Interface
 */
interface StorageInterface
{
    /**
     * Read data from file
     *
     * @param string $path
     * @return mixed
     */
    public function read($path);

    /**
     * Write data to file
     *
     * @param string $path
     * @param mixed $data
     * @return void
     */
    public function write($path, $data);

    /**
     * Check if file exists
     *
     * @param string $path
     * @return boolean
     */
    public function exists($path);
}

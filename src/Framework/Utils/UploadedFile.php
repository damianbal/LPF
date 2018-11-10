<?php

namespace LPF\Framework\Utils;

use LPF\Framework\Filesystem\StorageInterface;

/**
 * Handle uploaded file with that class
 */
class UploadedFile
{
    protected $name = null;
    protected $file = null;
    protected $extension = "";
    protected $fileName = "";
    protected $size = 0;
    
    /** @var StorageInterface */
    protected $storage = null;

    public function __construct(
        StorageInterface $storage,
        $file = null
    )
    {

        // if string is passed then get uploaded file from $_FILES
        if (is_string($file)) {
            $this->file = $_FILES[$file];
        } else {
            $this->file = $file;
        }

        // error
        if($this->file["error"] != 0)
        {
           throw new \Exception("Error uploading file", 9000);
        }

        // set storage
        $this->storage = $storage;

        // grab some details from file
        $this->fileName = basename($this->file["name"]);
        $this->extension = strtolower(pathinfo($this->file, PATHINFO_EXTENSION));
        $this->size = $this->file["size"];
    }

    /**
     * Size in bytes
     *
     * @return void
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Returns uploaded file extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Save uploaded file
     *
     * @return string
     */
    public function save($directory = "", $filename = null)
    {
        $orgName = $this->fileName;
        $tmp = $this->file["tmp_name"];
        $ext = $this->extension;
        $name = bin2hex(random_bytes(16));

        if($filename != null) {
            $name = $filename;
        }

        $path = ltrim($directory) . $name . "." . $ext;

        $this->storage->write($path, file_get_contents($tmp));

        return $path;
    }
}

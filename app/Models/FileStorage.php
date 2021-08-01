<?php

namespace App\Models;

use Exception;
use App\Models\Str;

class FileStorage
{
    protected $file;
    protected $extension;
    protected $currentLocation;
    protected $generatedName;

    // Divides the file into its component parts
    public function __construct(array $file)
    {
        $this->file = $file;

        $this->extension = strtolower(pathinfo($this->file['name'], PATHINFO_EXTENSION));
        $this->currentLocation = $this->file['tmp_name'];
        $this->generatedName = Str::token() . '.' . $this->extension;
    }

    public function getGeneratedName()
    {
        return $this->generatedName;
    }

    // Moves the file from its temp directory to the destination path
    public function saveIn($folder)
    {
        $destination = "{$folder}/{$this->generatedName}";

        if (!move_uploaded_file($this->currentLocation, $destination)) {
            throw new Exception('We encountered an error uploading the image.');
        }
    }
}

<?php

namespace App\Models;

use Exception;

class FileStorage {
    private $file;
    private $extension;
    private $currentLocation;
    private $generatedName;

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

    public function saveIn(string $folder)
    {
        $destination = "{$folder}/{$this->generatedName}";

        if (!move_uploaded_file($this->currentLocation, $destination)) {
            throw new Exception('We encountered an error uploading the image');
        }
    }
}

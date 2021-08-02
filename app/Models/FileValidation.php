<?php

namespace App\Models;

use Exception;

class FileValidation {
    private $inputFiles;
    private $rules;
    private $errors = [];
    private $customMessages = [];
    private $allowedTypes = [
        'image' => [
            'jpg' => IMAGETYPE_JPEG,
            'jpeg' => IMAGETYPE_JPEG,
            'png' => IMAGETYPE_PNG
        ]
    ];

    public function __construct(array $files)
    {
        $this->inputFiles = $files;
    }

    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    public function validate()
    {
        foreach ($this->rules as $field => $fieldRules) {
            $fieldRules = explode('|', $fieldRules);
            $this->validateField($field, $fieldRules);
        }
    }

    public function validateField(string $field, array $fieldRules)
    {
        foreach ($fieldRules as $fieldRule) {
            $ruleSegments = explode(':', $fieldRule);
            $fieldRule = $ruleSegments[0];
            $satisfier = $ruleSegments[1] ?? null;

            try {
                $this->{$fieldRule}($field, $satisfier);
            } catch (Exception $e) {
                if (isset($this->customMessages["$field.$fieldRule"])) {
                    $this->errors[$field][] = $this->customMessages["$field.$fieldRule"];
                } else {
                    $this->errors[$field][] = $e->getMessage();
                }

                if ($fieldRule === 'required') {
                    break;
                }
            }
        }
    }

    public function fails()
    {
        return !empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function required($field)
    {
        if (!isset($this->inputFiles[$field]) || $this->inputFiles[$field]['size'] === 0) {
            throw new Exception("The $field must not be empty.");
        }
    }

    private function type($field, $type)
    {
        $allowedExtensions = array_keys($this->allowedTypes[$type]);
        $extension = strtolower(pathinfo($this->inputFiles[$field]['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions)) {
            throw new Exception("The $field must be of type $type");
        }

        $currentLocation = $this->inputFiles[$field]['tmp_name'];
        $detectedDataType = exif_imagetype($currentLocation);
        $allowedDataType = $this->allowedTypes[$type][$extension];

        if ($detectedDataType !== $allowedDataType) {
            throw new Exception("The $field must be of type $detectedDataType");
        }
    }

    private function maxsize($field, $allowedSize)
    {
        if ($this->inputFiles[$field]['size'] > $allowedSize) {
            throw new Exception("The $field must not exceed $allowedSize bytes");
        }
    }
}

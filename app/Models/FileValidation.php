<?php

namespace App\Models;

class FileValidation
{
    protected $errorHandler;
    protected $file;
    protected $size;
    protected $allowedTypes = [
        'image' => [
            'jpg'	=> IMAGETYPE_JPEG,
            'jpeg'	=> IMAGETYPE_JPEG,
            'png'	=> IMAGETYPE_PNG
        ]
    ];
    protected $validRules = ['required', 'maxsize', 'type'];
    protected $messages = [
        'required'	=> 'The :field field is required.',
        'maxsize'	=> 'The :field file must not exceed :satisfier bytes.',
        'type'		=> 'The :field file must be of type :satisfier.'
    ];

    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    public function validate($file, array $rules)
    {
        $this->file = $file;
        $this->extension = strtolower(pathinfo($this->file['name'], PATHINFO_EXTENSION));
        $this->size = $this->file['size'];
        $this->currentLocation = $this->file['tmp_name'];

        foreach ($rules as $rule => $satisfier) {
            $field = 'image';

            $passes = $this->{$rule}($satisfier);

            if (!$passes) {
                $errorMessage = str_replace(
                    [':field', ':satisfier'],
                    [$field, $satisfier],
                    $this->messages[$rule]
                );

                $this->errorHandler->addError($errorMessage, $field);
            }
        }
    }

    // Checks if extension and data type match any allowed types
    public function type($type)
    {
        // Does the extension match
        $allowedExtensions = array_keys($this->allowedTypes[$type]);
        if (!in_array($this->extension, $allowedExtensions)) {
            return false;
        }

        // Does the type match
        $detectedDataType = exif_imagetype($this->currentLocation);
        $allowedDataType = $this->allowedTypes[$type][$this->extension];
        if ($detectedDataType !== $allowedDataType) {
            return false;
        }

        return true;
    }

    public function required()
    {
        return !empty($this->file) && $this->size > 0;
    }

    public function maxsize($allowedSize)
    {
        return $this->size < $allowedSize;
    }
}

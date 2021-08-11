<?php

namespace App\Decorators;

use App\Models\Str;
use App\Models\Sanitization;

class SanitizeDecorator {
    private $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    public function __call(string $methodName, array $arguments)
    {
        if (method_exists($this->object, $methodName)) {
            $returnValue = $this->object->{$methodName}(...$arguments);

            if (is_string($returnValue)) {
                return Str::sanitize($returnValue);
            }

            if (is_array($returnValue)) {
                return Sanitization::sanitize($returnValue);
            }

            if (is_object($returnValue)) {
                return new SanitizeDecorator($returnValue);
            }

            return $returnValue;
        }
    }
}

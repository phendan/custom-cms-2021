<?php

namespace App\Models;

use App\Models\Str;
use App\Decorators\SanitizeDecorator;

class Sanitization {
    // Recursively sanitize array
    public static function sanitize(array $data) {
        $data = array_map(function ($element) {
            if (is_string($element)) {
                return Str::sanitize($element);
            }

            if (is_array($element)) {
                return self::sanitize($element);
            }

            if (is_object($element)) {
                return new SanitizeDecorator($element);
            }

            return $element;
        }, $data);

        return $data;
    }
}

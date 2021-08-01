<?php

namespace App\Models;

class Str {
    public static function sanitize(string $input)
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'utf-8');
    }
}

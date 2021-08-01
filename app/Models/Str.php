<?php

namespace App\Models;

class Str
{
    public static function sanitize(string $input)
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'utf-8');
    }

    public static function slug(string $string)
    {
        $disallowedCharacters = '/[^\-\s\pN\pL]+/u';
        $spacesDuplicateHyphens = '/[\-\s]+/';

        $slug = mb_strtolower($string, 'UTF-8');
        $slug = preg_replace($disallowedCharacters, '', $slug);
        $slug = preg_replace($spacesDuplicateHyphens, '-', $slug);

        return $slug;
    }

    public static function token(int $length = 16)
    {
        return bin2hex(random_bytes($length));
    }
}

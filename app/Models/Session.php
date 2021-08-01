<?php

namespace App\Models;

class Session {
    public static function exists($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function get($key)
    {
        if (self::exists($key)) {
            return $_SESSION[$key];
        }

        return null;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function delete($key)
    {
        unset($_SESSION[$key]);
    }

    // Sets a session once, deletes it again when looked up next
    public static function flash($key, $message = null)
    {
        if (self::exists($key)) {
            $message = self::get($key);
            self::delete($key);

            return $message;
        }

        self::set($key, $message);
    }
}

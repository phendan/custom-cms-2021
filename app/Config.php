<?php

namespace App;

class Config {
    private static $options = [
        'root' => '/cms-entwicklung/public',
        'database' => [
            'host' => '127.0.0.1',
            'dbName' => 'cms',
            'username' => 'root',
            'password' => ''
        ]
    ];

    public static function get(string $selector) {
        $elements = explode('.', $selector);
        $dataset = self::$options;

        foreach ($elements as $element) {
            $dataset = $dataset[$element];
        }

        return $dataset;
    }
}

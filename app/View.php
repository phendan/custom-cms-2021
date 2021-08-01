<?php

namespace App;

use App\Config;
use App\Models\Session;
use App\Models\Str;

class View {
    public function render($view, array $data = [])
    {
        $data['session'] = Session::class;
        $data['root'] = Config::get('root');

        $data = array_map(function ($element) {
            if (is_string($element)) {
                return Str::sanitize($element);
            }

            return $element;
        }, $data);

        extract($data);

        require_once '../app/Views/partials/header.php';
        require_once "../app/Views/{$view}.php";
        require_once '../app/Views/partials/footer.php';

        exit();
    }
}

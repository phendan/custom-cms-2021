<?php

namespace App;

use App\Config;
use App\Models\Sanitization;
use App\Models\Session;

class View {
    public function render($view, array $data = [])
    {
        $session = Session::class;
        $root = Config::get('root');

        $data = Sanitization::sanitize($data);
        extract($data);

        require_once '../app/Views/partials/header.php';
        require_once "../app/Views/{$view}.php";
        require_once '../app/Views/partials/footer.php';

        exit();
    }
}

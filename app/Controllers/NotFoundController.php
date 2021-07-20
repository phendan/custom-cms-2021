<?php

namespace App\Controllers;

use App\Interfaces\BaseController;

class NotFoundController extends BaseController {
    public function index()
    {
        echo 'The page you tried to access does not exist.';
    }
}

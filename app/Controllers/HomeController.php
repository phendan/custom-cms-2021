<?php

namespace App\Controllers;

use App\Models\User;
use App\Interfaces\BaseController;

class HomeController extends BaseController {
    public function index()
    {
        echo 'home';
    }
}

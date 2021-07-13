<?php

namespace App\Controllers;

require_once '../app/Models/Database.php';

use App\Models\Database;
use App\Models\User;

class HomeController {
    public function index()
    {
        echo 'home';
    }
}

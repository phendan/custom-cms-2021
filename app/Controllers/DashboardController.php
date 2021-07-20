<?php

namespace App\Controllers;

use App\Models\User;
use App\Interfaces\BaseController;

class DashboardController extends BaseController {
    public function index()
    {
        echo 'dashboard';
        var_dump($_SESSION);
    }
}

<?php

namespace App\Controllers;

use App\Request;
use App\Traits\RouteGuards\AdminOnly;

class AdminController
{
    use AdminOnly;

    public function index(Request $request)
    {
    }

    public function write(Request $request)
    {
    }
}

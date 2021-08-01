<?php

namespace App\Controllers;

use App\Models\User;
use App\Interfaces\BaseController;
use App\Request;

class HomeController extends BaseController {
    public function index(Request $request)
    {
        $this->renderView('home', [
            'test' => '<script>alert("test")</script>'
        ]);
    }
}

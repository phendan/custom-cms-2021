<?php

namespace App\Controllers;

use App\Request;
use App\Models\User;
use App\Models\Email;
use App\Interfaces\BaseController;

class HomeController extends BaseController {
    public function index(Request $request)
    {
        $email = new Email;
        $email->send('custom.cms.dummy@gmail.com', 'Registration', 'You have been successfully registered.');

        $this->renderView('home', [
            'test' => '<script>alert("test")</script>'
        ]);
    }
}

<?php

namespace App\Controllers;

use App\Interfaces\BaseController;
use App\Models\FormValidation;
use App\Models\Session;
use App\Request;
use Exception;
use App\Traits\RouteGuards\GuestOnly;

class LoginController extends BaseController {
    use GuestOnly;

    public function index(Request $request)
    {
        if (!$request->hasInput()) {
            return $this->renderView('login');
        }

        $userData = $request->getInput();
        $validation = new FormValidation($this->db, $userData);

        $validation->setRules([
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        $validation->validate();

        if ($validation->fails()) {
            return $this->renderView('login', [
                'errors' => $validation->getErrors()
            ]);
        }

        try {
            $this->user->login($userData['email'], $userData['password']);
            Session::flash('message', 'You have been successfully logged in!');
            $this->redirect('/dashboard');
        } catch (Exception $e) {
            $this->renderView('login', [
                'errors' => [
                    'root' => $e->getMessage()
                ]
            ]);
        }
    }
}

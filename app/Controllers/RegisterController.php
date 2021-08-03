<?php

namespace App\Controllers;

use App\Models\FormValidation;
use App\Interfaces\BaseController;
use App\Models\Session;
use App\Request;
use App\Models\Email;
use App\Traits\RouteGuards\GuestOnly;

class RegisterController extends BaseController {
    use GuestOnly;

    public function index(Request $request)
    {
        if (!$request->hasInput()) {
            return $this->renderView('register');
        }

        $userData = $request->getInput();
        $validation = new FormValidation($this->db, $userData);

        $validation->setRules([
            'firstName' => 'required|min:2|max:32',
            'lastName' => 'required|min:2|max:32',
            'email' => 'required|email|available:users',
            'password' => 'required|min:5',
            'passwordAgain' => 'required|matches:password',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            return $this->renderView('register', [
                'errors' => $validation->getErrors()
            ]);
        }

        $this->user->register(
            ...$request->only(
                'firstName',
                'lastName',
                'email',
                'password'
            )
        );
        $email = new Email;
        // $email->send($request->only('email'), 'Registration', 'You have been successfully registered.');
        Session::flash('message', 'Your account has been successfully created!');
        $this->redirect('/');
    }
}

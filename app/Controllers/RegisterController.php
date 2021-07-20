<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\FormValidation;
use App\Interfaces\BaseController;

class RegisterController extends BaseController {
    public function index()
    {
        if (!empty($_POST)) {
            $userData = array_map(function ($element) {
                return trim($element);
            }, $_POST);

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
                $this->view->render('register', [
                    'errors' => $validation->getErrors()
                ]);
            } else {
                $user = new User($this->db);
                $user->register(
                    $userData['firstName'],
                    $userData['lastName'],
                    $userData['email'],
                    $userData['password']
                );
                $this->redirect('/');
            }
        }

        $this->view->render('register');
    }
}

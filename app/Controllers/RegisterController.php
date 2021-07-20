<?php

namespace App\Controllers;

use App\View;
use App\Models\User;
use App\Models\Database;
use App\Models\FormValidation;

class RegisterController {
    public function index()
    {
        $view = new View;

        if (!empty($_POST)) {
            $userData = array_map(function ($element) {
                return trim($element);
            }, $_POST);

            $db = new Database;

            $validation = new FormValidation($db, $userData);

            $validation->setRules([
                'firstName' => 'required|min:2|max:32',
                'lastName' => 'required|min:2|max:32',
                'email' => 'required|email|available:users',
                'password' => 'required|min:5',
                'passwordAgain' => 'required|matches:password',
            ]);

            $validation->validate();

            if ($validation->fails()) {
                $view->render('register', [
                    'errors' => $validation->getErrors()
                ]);
            } else {
                $user = new User($db);
                $user->register(
                    $userData['firstName'],
                    $userData['lastName'],
                    $userData['email'],
                    $userData['password']
                );
            }
        }

        $view->render('register');
    }
}

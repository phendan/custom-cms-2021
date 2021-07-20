<?php

namespace App\Controllers;

use App\Interfaces\BaseController;
use App\Models\FormValidation;
use App\Models\User;
use Exception;

class LoginController extends BaseController {
    public function index()
    {
        if (!empty($_POST)) {
            $userData = array_map(function ($element) {
                return trim($element);
            }, $_POST);

            $validation = new FormValidation($this->db, $userData);

            $validation->setRules([
                'email' => 'required|email',
                'password' => 'required|min:5'
            ]);

            $validation->validate();

            if ($validation->fails()) {
                $this->view->render('login', [
                    'errors' => $validation->getErrors()
                ]);
            } else {
                $user = new User($this->db);

                try {
                    $user->login($userData['email'], $userData['password']);
                    $this->redirect('/dashboard');
                } catch (Exception $e) {
                    $this->view->render('login', [
                        'errors' => [
                            'root' => $e->getMessage()
                        ]
                    ]);
                }
            }
        }

        $this->view->render('login');
    }
}

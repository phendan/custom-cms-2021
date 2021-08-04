<?php

namespace App\Interfaces;

use App\View;
use App\Config;
use App\Models\Database;
use App\Models\User;
use App\Request;

abstract class BaseController {
    protected $view;
    protected $db;
    protected $user;

    public function __construct()
    {
        $this->db = new Database;
        $this->user = new User($this->db);
        $this->view = new View;

        if ($this->user->isLoggedIn()) {
            $this->user->find($this->user->getId());
        }
    }

    abstract public function index(Request $request);

    protected function redirect($path) {
        header('Location: ' . Config::get('root') . $path);
        exit();
    }

    protected function renderView($view, array $data = [])
    {
        $data['user'] = $this->user;
        $this->view->render($view, $data);
    }

    protected function renderJson(int $statusCode, array $data)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}

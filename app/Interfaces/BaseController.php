<?php

namespace App\Interfaces;

use App\View;
use App\Config;
use App\Models\Database;


abstract class BaseController {
    protected $view;
    protected $db;

    public function __construct()
    {
        $this->db = new Database;
        $this->view = new View;
    }

    abstract public function index();

    protected function redirect($path) {
        header('Location: ' . Config::get('root') . $path);
        exit();
    }
}

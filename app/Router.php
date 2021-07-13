<?php

namespace App;

use App\Controllers\HomeController;
use App\Controllers\NotFoundController;

class Router {
    private $controller = HomeController::class;
    private $method = 'index';
    private $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();
        if (!$url) return;

        $requestedController = 'App\\Controllers\\' . ucfirst($url[0]) . 'Controller';

        if (!class_exists($requestedController)) {
            $this->controller = NotFoundController::class;
            return;
        }

        $this->controller = $requestedController;
        unset($url[0]);

        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->params = array_values($url);
    }

    private function parseUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
    }

    public function getRequestedController()
    {
        return $this->controller;
    }

    public function getRequestedMethod()
    {
        return $this->method;
    }

    public function getParams()
    {
        return $this->params;
    }
}

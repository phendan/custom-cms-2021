<?php

class Router {
    private $controller = 'HomeController';
    private $method = 'index';
    private $params;

    public function __construct()
    {
        $url = $this->parseUrl();

        $requestedController = ucfirst($url[0] ?? '') . 'Controller';
        $controllerPath = "../app/Controllers/{$requestedController}.php";

        if ($url && file_exists($controllerPath)) {
            require_once $controllerPath;
            $this->controller = $requestedController;
            unset($url[0]);
        } else {
            require_once "../app/Controllers/{$this->controller}.php";
        }

        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];
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

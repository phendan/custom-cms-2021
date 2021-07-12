<?php

require_once '../app/Router.php';

class App {
    public function __construct()
    {
        $router = new Router;

        $requestedController = $router->getRequestedController();
        $requestedMethod = $router->getRequestedMethod();
        $params = $router->getParams();

        $controller = new $requestedController;
        $controller->{$requestedMethod}(...$params);
    }
}

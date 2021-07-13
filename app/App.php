<?php

namespace App;

use App\Router;

class App {
    public function __construct()
    {
        $this->autoloadClasses();

        $router = new Router;

        $requestedController = $router->getRequestedController();
        $requestedMethod = $router->getRequestedMethod();
        $params = $router->getParams();

        $controller = new $requestedController;
        $controller->{$requestedMethod}(...$params);
    }

    private function autoloadClasses()
    {
        spl_autoload_register(function($className) {
            $projectNamespace = 'App\\';
            $className = str_replace($projectNamespace, '', $className);
            $file = '../app/' . str_replace('\\', '/', $className) . '.php';

            if (file_exists($file)) {
                require_once $file;
            }
        });
    }
}

<?php

namespace Src\Controllers;

class RequestController
{
    protected array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function handleRequest(string $httpMethod, string $requestUri)
    {
        $path = parse_url($requestUri, PHP_URL_PATH) ?: '/';

        if (! isset($this->routes[$httpMethod][$path])) {
            http_response_code(404);
            return $this->render404();
        }

        $action = $this->routes[$httpMethod][$path];
        $controllerCls = $action['controller'];
        $actionMethod = $action['method'];
        $controller = new $controllerCls();
        $requiresAuth  = $action['auth'] ?? false;

        if ($requiresAuth && empty($_SESSION['user'])) {
            redirect('/login');
        }

        $input = [];

        if (in_array($httpMethod, ['GET', 'DELETE'], true)) {
            $input = $_GET;
        } elseif (in_array($httpMethod, ['POST', 'PUT', 'PATCH'], true)) {
            $input = $_POST;
        }

        return $controller->$actionMethod($input);
    }

    protected function render404(): string
    {
        return '<h1>404 – Página não encontrada</h1>';
    }
}

<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$requestUri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

use Src\Controllers\RequestController;

$routes = require __DIR__ . '/../src/Config/routes.php';

try {
    $controller = new RequestController($routes);
    $response = $controller->handleRequest($method, $requestUri);

    echo $response;
} catch (\Throwable $th) {
    echo "<h2>Erro Inesperado: " . $th->getMessage() . "</h2>";

    if ($_ENV['APP_ENV'] == 'development') {
        dd($th);
    }
}

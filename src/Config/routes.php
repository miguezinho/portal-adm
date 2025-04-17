<?php

use Src\Controllers\AuthController;
use Src\Controllers\DashboardController;
use Src\Controllers\CustomerController;
use Src\Controllers\UserController;

return [
    'GET' => [
        '/login' => [
            'controller' => AuthController::class,
            'method' => 'showLoginForm',
            'auth' => false,
        ],
        '/register' => [
            'controller' => AuthController::class,
            'method' => 'showRegisterForm',
            'auth' => false,
        ],
        '/logout' => [
            'controller' => AuthController::class,
            'method' => 'logout',
            'auth' => true,
        ],

        '/' => [
            'controller' => DashboardController::class,
            'method' => 'index',
            'auth' => true,
        ],
        '/dashboard' => [
            'controller' => DashboardController::class,
            'method' => 'index',
            'auth' => true,
        ],
        '/customers' => [
            'controller' => CustomerController::class,
            'method' => 'index',
            'auth' => true,
        ],
        '/customers/create' => [
            'controller' => CustomerController::class,
            'method' => 'create',
            'auth' => true,
        ],
        '/users' => [
            'controller' => UserController::class,
            'method' => 'index',
            'auth' => true,
        ],
    ],

    'POST' => [
        '/login' => [
            'controller' => AuthController::class,
            'method' => 'login',
            'auth' => false,
        ],
        '/register' => [
            'controller' => AuthController::class,
            'method' => 'register',
            'auth' => false,
        ],
        '/customers/save' => [
            'controller' => CustomerController::class,
            'method' => 'save',
            'auth' => true,
        ],
    ],
];

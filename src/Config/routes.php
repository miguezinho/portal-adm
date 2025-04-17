<?php

use Src\Controllers\AuthController;
use Src\Controllers\DashboardController;
use Src\Controllers\CustomerController;
use Src\Controllers\UserController;

return [
    'GET' => [
        '/login'       => [
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
            'auth'       => true,
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
            'method' => 'customers',
            'auth' => true,
        ],
        '/users' => [
            'controller' => UserController::class,
            'method' => 'users',
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
        '/customers' => [
            'controller' => CustomerController::class,
            'method' => 'customers',
            'auth' => true,
        ],
    ],
];

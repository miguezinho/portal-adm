<?php

namespace Src\Controllers;

use Src\Adapters\Repositories\PdoUserRepository;
use Src\Config\DatabaseConfig;
use Src\Core\UseCases\UserLoginUseCase;
use Src\Core\UseCases\UserRegisterUseCase;

class AuthController
{
    public function showLoginForm(): string
    {
        return view('auth/form-login', [], 'layout-login');
    }

    public function showRegisterForm(): string
    {
        return view('auth/form-register', [
            'headerTitle' => 'Registrar-se'
        ], 'layout-login');
    }

    public function login(array $input): void
    {
        $pdoConnection = DatabaseConfig::getPdoConnection();
        $repository = new PdoUserRepository($pdoConnection);
        $useCase = new UserLoginUseCase($repository);

        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';

        try {
            $user = $useCase->execute($email, $password);

            $_SESSION['user'] = [
                'id' => $user->getId(),
                'name'  => $user->getName(),
                'email' => $user->getEmail(),
            ];

            redirect('/dashboard');
        } catch (\Throwable $e) {
            redirect('/login?errorMessage=' . urlencode($e->getMessage()));
        }
    }


    public function register(array $input): void
    {
        $pdoConnection = DatabaseConfig::getPdoConnection();
        $repository = new PdoUserRepository($pdoConnection);
        $useCase = new UserRegisterUseCase($repository);

        try {
            $user = $useCase->execute($input);
            $_SESSION['user'] = [
                'id' => $user->getId(),
                'name'  => $user->getName(),
                'email' => $user->getEmail(),
            ];
            redirect('/dashboard');
        } catch (\Throwable $e) {
            redirect('/register?errorMessage=' . urlencode($e->getMessage()));
        }
    }

    public function logout(): void
    {
        session_destroy();
        redirect('/login');
    }
}

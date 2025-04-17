<?php

namespace Src\Controllers;

use Src\Adapters\Repositories\PdoUserRepository;
use Src\Config\DatabaseConfig;
use Src\Core\UseCases\RegisterUserUseCase;

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
        $email    = $input['email'] ?? '';
        $password = $input['password'] ?? '';
        // AQUI você valida no banco de dados, ORM, etc.
        // Exemplo simples hard‑coded:
        if ($email === 'admin@exemplo.com' && $password === 'senha123') {
            // salva o usuário na sessão
            $_SESSION['user'] = [
                'email' => $email,
                'name'  => 'Administrador',
            ];

            // redireciona para área interna
            header('Location: /dashboard');
            exit;
        }

        // volta pro login com erro (poderia usar flash message)
        header('Location: /login?errorMessage=1');
        exit;
    }

    public function register(array $input): void
    {
        $pdoConnection = DatabaseConfig::getPdoConnection();
        $repository = new PdoUserRepository($pdoConnection);
        $useCase = new RegisterUserUseCase($repository);

        try {
            $user = $useCase->execute($input);
            $_SESSION['user'] = [
                'id' => $user->getId(),
                'name'  => $user->getName(),
                'email' => $user->getEmail(),
            ];
            header('Location: /dashboard');
            exit;
        } catch (\Throwable $e) {
            dd($e->getMessage());
            header('Location: /register?errorMessage=' . urlencode($e->getMessage()));
            exit;
        }
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}

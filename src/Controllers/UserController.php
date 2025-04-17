<?php

namespace Src\Controllers;

use Src\Adapters\Repositories\PdoUserRepository;
use Src\Config\DatabaseConfig;
use Src\Core\UseCases\UserListUseCase;

class UserController
{
    public function index()
    {
        $pdoConnection = DatabaseConfig::getPdoConnection();
        $repository = new PdoUserRepository($pdoConnection);
        $useCase = new UserListUseCase($repository);

        try {
            $users = $useCase->execute();

            return view('user/index', [
                'title' => 'Usuários',
                'headerTitle' => 'Lista de Usuários',
                'users' => $users,
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}

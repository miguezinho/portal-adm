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
                'title' => 'Guardiões',
                'headerTitle' => 'Lista de Guardiões',
                'users' => $users,
                'icon' => 'fa-user-secret',
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}

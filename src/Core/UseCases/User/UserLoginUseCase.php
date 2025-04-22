<?php

namespace Src\Core\UseCases\User;

use Src\Core\Entities\UserEntity;
use Src\Core\UseCases\Contracts\UserRepositoryInterface;

class UserLoginUseCase
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $email, string $password): UserEntity
    {
        $user = $this->repository->findByEmail($email);

        if (!$user || !password_verify($password, $user->getPasswordHash())) {
            throw new \InvalidArgumentException("Credenciais inválidas.");
        }

        return $user;
    }
}

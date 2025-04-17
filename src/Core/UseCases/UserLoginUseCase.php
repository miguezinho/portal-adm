<?php

namespace Src\Core\UseCases;

use Src\Core\Entities\UserEntity;
use Src\Core\UseCases\Contracts\UserRepositoryInterface;

class UserLoginUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $email, string $password): UserEntity
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !password_verify($password, $user->getPasswordHash())) {
            throw new \InvalidArgumentException("Credenciais inválidas.");
        }

        return $user;
    }
}

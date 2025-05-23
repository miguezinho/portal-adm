<?php

namespace Src\Core\UseCases\User;

use Src\Core\Entities\UserEntity;
use Src\Core\Contracts\UserRepositoryInterface;

class UserRegisterUseCase
{
    public function __construct(private UserRepositoryInterface $repository) {}

    public function execute(array $input): UserEntity
    {
        if (empty($input['name']) || empty($input['email']) || empty($input['password'])) {
            throw new \InvalidArgumentException("Todos os campos são obrigatórios.");
        }
        if (($input['password'] ?? '') !== ($input['password_confirmation'] ?? '')) {
            throw new \InvalidArgumentException("Senhas não conferem.");
        }
        if ($this->repository->findByEmail($input['email'])) {
            throw new \InvalidArgumentException("E‑mail já cadastrado.");
        }

        $hash = password_hash($input['password'], PASSWORD_BCRYPT);
        $user = new UserEntity($input['name'], $input['email'], $hash);

        return $this->repository->save($user);
    }
}

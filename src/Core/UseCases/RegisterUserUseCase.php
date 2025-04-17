<?php

namespace Src\Core\UseCases;

use Src\Core\Entities\UserEntity;
use Src\Core\UseCases\Contracts\UserRepositoryInterface;

class RegisterUserUseCase
{
    public function __construct(private UserRepositoryInterface $repo) {}

    public function execute(array $input): UserEntity
    {
        if (empty($input['name']) || empty($input['email']) || empty($input['password'])) {
            throw new \InvalidArgumentException("Todos os campos são obrigatórios.");
        }
        if (($input['password'] ?? '') !== ($input['password_confirmation'] ?? '')) {
            throw new \InvalidArgumentException("Senhas não conferem.");
        }
        if ($this->repo->findByEmail($input['email'])) {
            throw new \InvalidArgumentException("E‑mail já cadastrado.");
        }

        $hash = password_hash($input['password'], PASSWORD_BCRYPT);
        $user = new UserEntity($input['name'], $input['email'], $hash);

        return $this->repo->save($user);
    }
}

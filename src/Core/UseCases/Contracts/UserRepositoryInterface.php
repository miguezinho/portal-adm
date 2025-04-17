<?php

namespace Src\Core\UseCases\Contracts;

use Src\Core\Entities\UserEntity;

interface UserRepositoryInterface
{
    public function save(UserEntity $user): UserEntity;
    public function findByEmail(string $email): ?UserEntity;
    public function list(): array;
}

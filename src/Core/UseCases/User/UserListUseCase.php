<?php

namespace Src\Core\UseCases\User;

use Src\Core\UseCases\Contracts\UserRepositoryInterface;

class UserListUseCase
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->list();
    }
}

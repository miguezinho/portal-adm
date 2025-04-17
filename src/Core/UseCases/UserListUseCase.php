<?php

namespace Src\Core\UseCases;

use Src\Core\UseCases\Contracts\UserRepositoryInterface;

class UserListUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(): array
    {
        return $this->userRepository->list();
    }
}

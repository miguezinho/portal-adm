<?php

namespace Src\Core\UseCases;

use Src\Core\UseCases\Contracts\CustomerRepositoryInterface;

class CustomerListUseCase
{
    private CustomerRepositoryInterface $userRepository;

    public function __construct(CustomerRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(): array
    {
        return $this->userRepository->list();
    }
}

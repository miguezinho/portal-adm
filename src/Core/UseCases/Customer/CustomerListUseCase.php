<?php

namespace Src\Core\UseCases\Customer;

use Src\Core\Contracts\CustomerRepositoryInterface;

class CustomerListUseCase
{
    private CustomerRepositoryInterface $repository;

    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->list();
    }
}

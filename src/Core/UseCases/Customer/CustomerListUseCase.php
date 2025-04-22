<?php

namespace Src\Core\UseCases;

use Src\Core\UseCases\Contracts\CustomerRepositoryInterface;

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

<?php

namespace Src\Core\UseCases;

use Src\Core\UseCases\Contracts\CustomerRepositoryInterface;

class CustomerDeleteUseCase
{
    private CustomerRepositoryInterface $repository;

    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        return $this->repository->delete($id);
    }
}

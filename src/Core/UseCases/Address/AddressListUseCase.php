<?php

namespace Src\Core\UseCases\Address;

use Src\Core\UseCases\Contracts\AddressRepositoryInterface;

class AddressListUseCase
{
    private AddressRepositoryInterface $repository;

    public function __construct(AddressRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute($customerId = null): array
    {
        if ($customerId) {
            return $this->repository->listByCustomerId($customerId);
        }

        return $this->repository->list();
    }
}

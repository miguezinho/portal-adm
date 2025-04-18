<?php

namespace Src\Core\UseCases;

use Src\Core\UseCases\Contracts\AddressRepositoryInterface;

class AddressListUseCase
{
    private AddressRepositoryInterface $repository;

    public function __construct(AddressRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $customerId): array
    {
        return $this->repository->listByCustomerId($customerId);
    }
}

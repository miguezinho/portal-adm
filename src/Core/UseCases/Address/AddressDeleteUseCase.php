<?php

namespace Src\Core\UseCases\Address;

use Src\Core\UseCases\Contracts\AddressRepositoryInterface;

class AddressDeleteUseCase
{
    private AddressRepositoryInterface $repository;

    public function __construct(AddressRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        return $this->repository->delete($id);
    }
}

<?php

namespace Src\Core\UseCases\Contracts;

use Src\Core\Entities\CustomerEntity;

interface CustomerRepositoryInterface
{
    public function save(CustomerEntity $user): CustomerEntity;
    public function edit(CustomerEntity $user): CustomerEntity;
    public function find(int $id): ?CustomerEntity;
    public function findByCpf(string $cpf): ?CustomerEntity;
    public function findByRg(string $rg): ?CustomerEntity;
    public function delete(int $id): bool;
    public function list(): array;
}

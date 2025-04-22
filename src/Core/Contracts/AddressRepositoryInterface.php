<?php

namespace Src\Core\Contracts;

use Src\Core\Entities\AddressEntity;

interface AddressRepositoryInterface
{
    public function save(AddressEntity $user): AddressEntity;
    public function delete(int $id): bool;
    public function listByCustomerId(int $customerId): array;
    public function list(): array;
}

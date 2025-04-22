<?php

namespace Src\Core\UseCases\Customer;

use Src\Core\Entities\CustomerEntity;
use Src\Core\Contracts\CustomerRepositoryInterface;

class CustomerFindUseCase
{
    private CustomerRepositoryInterface $repository;
    private string $searchType;

    public function __construct(CustomerRepositoryInterface $repository, string $searchType)
    {
        if (!in_array($searchType, ['id', 'cpf', 'rg'], true)) {
            throw new \InvalidArgumentException("Tipo de busca inválido '{$searchType}'. Tipos permitidos: 'id', 'cpf', 'rg'.");
        }

        $this->repository = $repository;
        $this->searchType = $searchType;
    }

    public function execute(mixed $value): ?CustomerEntity
    {
        switch ($this->searchType) {
            case 'id':
                return $this->findById($value);
            case 'cpf':
                return $this->findByCpf($value);
            case 'rg':
                return $this->findByRg($value);
        }

        return null;
    }

    private function findById(int $id): ?CustomerEntity
    {
        return $this->repository->find($id);
    }

    private function findByCpf(string $cpf): ?CustomerEntity
    {
        return $this->repository->findByCpf($cpf);
    }

    private function findByRg(string $rg): ?CustomerEntity
    {
        return $this->repository->findByRg($rg);
    }
}

<?php

namespace Src\Core\UseCases;

use Src\Core\Entities\CustomerEntity;
use Src\Core\UseCases\Contracts\CustomerRepositoryInterface;

class CustomerFindUseCase
{
    private CustomerRepositoryInterface $customerRepository;
    private string $searchType;

    public function __construct(CustomerRepositoryInterface $customerRepository, string $searchType)
    {
        if (!in_array($searchType, ['id', 'cpf', 'rg'], true)) {
            throw new \InvalidArgumentException("Invalid search type '{$searchType}'. Allowed types: 'id', 'cpf', 'rg'.");
        }

        $this->customerRepository = $customerRepository;
        $this->searchType = $searchType;
    }

    /**
     * Execute the search based on the predefined search type.
     * 
     * @param mixed $value The value to search for.
     * 
     * @return CustomerEntity|null
     */
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
        if (!is_int($id)) {
            throw new \InvalidArgumentException("The value for 'id' must be an integer.");
        }

        return $this->customerRepository->find($id);
    }

    private function findByCpf(string $cpf): ?CustomerEntity
    {
        if (!is_string($cpf)) {
            throw new \InvalidArgumentException("The value for 'cpf' must be a string.");
        }

        return $this->customerRepository->findByCpf($cpf);
    }

    private function findByRg(string $rg): ?CustomerEntity
    {
        if (!is_string($rg)) {
            throw new \InvalidArgumentException("The value for 'rg' must be a string.");
        }

        return $this->customerRepository->findByRg($rg);
    }
}

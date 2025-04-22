<?php

namespace Src\Core\UseCases\Customer;

use Src\Core\Entities\CustomerEntity;
use Src\Core\Contracts\CustomerRepositoryInterface;

class CustomerSaveUseCase
{
    public function __construct(private CustomerRepositoryInterface $repository) {}

    public function execute(array $data): CustomerEntity
    {
        $this->validateRequiredFields($data);

        $cpf = unmaskCpf($data['cpf']);
        $rg = unmaskRg($data['rg']);

        if (!empty($data['id'])) {
            return $this->updateCustomer($data, $cpf, $rg);
        }

        return $this->createCustomer($data, $cpf, $rg);
    }

    private function validateRequiredFields(array $data): void
    {
        $requiredFields = ['name', 'birth_date', 'cpf', 'rg', 'phone'];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new \InvalidArgumentException("Todos os campos são obrigatórios.");
            }
        }
    }

    private function updateCustomer(array $data, string $cpf, string $rg): CustomerEntity
    {
        $customer = $this->repository->find((int)$data['id']);

        if (!$customer) {
            throw new \InvalidArgumentException("Cliente com o ID fornecido não encontrado.");
        }

        $this->validateUniqueFieldsForUpdate($customer->getId(), $cpf, $rg);

        $updatedCustomer = new CustomerEntity(
            $data['name'],
            $data['birth_date'],
            $cpf,
            $rg,
            $data['phone'],
            (int) $data['id']
        );

        return $this->repository->edit($updatedCustomer);
    }

    private function createCustomer(array $data, string $cpf, string $rg): CustomerEntity
    {
        $this->validateUniqueFields($cpf, $rg);

        $newCustomer = new CustomerEntity(
            $data['name'],
            $data['birth_date'],
            $cpf,
            $rg,
            $data['phone']
        );

        return $this->repository->save($newCustomer);
    }

    private function validateUniqueFields(string $cpf, string $rg): void
    {
        if ($this->repository->findByCpf($cpf)) {
            throw new \InvalidArgumentException("CPF já cadastrado.");
        }

        if ($this->repository->findByRg($rg)) {
            throw new \InvalidArgumentException("RG já cadastrado.");
        }
    }

    private function validateUniqueFieldsForUpdate(int $currentCustomerId, string $cpf, string $rg): void
    {
        $existingCpf = $this->repository->findByCpf($cpf);
        if ($existingCpf && $existingCpf->getId() !== $currentCustomerId) {
            throw new \InvalidArgumentException("CPF já cadastrado.");
        }

        $existingRg = $this->repository->findByRg($rg);
        if ($existingRg && $existingRg->getId() !== $currentCustomerId) {
            throw new \InvalidArgumentException("RG já cadastrado.");
        }
    }
}

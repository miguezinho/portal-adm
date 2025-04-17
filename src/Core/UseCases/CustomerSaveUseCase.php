<?php

namespace Src\Core\UseCases;

use Src\Core\Entities\CustomerEntity;
use Src\Core\UseCases\Contracts\CustomerRepositoryInterface;

class CustomerSaveUseCase
{
    public function __construct(private CustomerRepositoryInterface $repository) {}

    public function execute(array $input): CustomerEntity
    {
        if (empty($input['name']) || empty($input['birth_date']) || empty($input['cpf']) || empty($input['rg']) || empty($input['phone'])) {
            throw new \InvalidArgumentException("Todos os campos são obrigatórios.");
        }

        if ($this->repository->findByCpf($input['cpf'])) {
            throw new \InvalidArgumentException("CPF já cadastrado.");
        }

        $customer = new CustomerEntity(
            $input['name'],
            $input['birth_date'],
            unmaskCpf($input['cpf']),
            $input['rg'],
            $input['phone']
        );

        return $this->repository->save($customer);
    }
}

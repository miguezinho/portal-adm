<?php

namespace Src\Core\UseCases;

use Src\Core\Entities\CustomerEntity;
use Src\Core\UseCases\Contracts\CustomerRepositoryInterface;

class CustomerSaveUseCase
{
    public function __construct(private CustomerRepositoryInterface $repository) {}

    public function execute(array $input): CustomerEntity
    {
        $cpf = unmaskCpf($input['cpf']);
        $rg = unmaskRg($input['rg']);

        if (empty($input['name']) || empty($input['birth_date']) || empty($cpf) || empty($rg) || empty($input['phone'])) {
            throw new \InvalidArgumentException("Todos os campos são obrigatórios.");
        }

        if ($this->repository->findByCpf($cpf)) {
            throw new \InvalidArgumentException("CPF já cadastrado.");
        }

        if ($this->repository->findByRg($cpf)) {
            throw new \InvalidArgumentException("RG já cadastrado.");
        }

        $customer = new CustomerEntity(
            $input['name'],
            $input['birth_date'],
            $cpf,
            $rg,
            $input['phone']
        );

        return $this->repository->save($customer);
    }
}

<?php

namespace Src\Core\UseCases;

use Src\Core\Entities\AddressEntity;
use Src\Core\UseCases\Contracts\AddressRepositoryInterface;

class AddressSaveUseCase
{
    public function __construct(private AddressRepositoryInterface $repository) {}

    public function execute(array $input): AddressEntity
    {
        $this->validate($input);

        $address = new AddressEntity(
            $input['customer_id'],
            $input['street'],
            $input['neighborhood'],
            $input['city'],
            $input['state'],
            $input['zip_code'],
            $input['number'],
            $input['complement'],
            $input['id'] ?? null,
        );

        return $this->repository->save($address);
    }

    private function validate(array $input): void
    {
        if (empty($input['customer_id']) || !is_numeric($input['customer_id'])) {
            throw new \InvalidArgumentException("ID do cliente é obrigatório e deve ser numérico.");
        }

        if (empty($input['zip_code']) || !preg_match('/^\d{8}$/', $input['zip_code'])) {
            throw new \InvalidArgumentException("CEP é obrigatório e deve conter 8 dígitos.");
        }

        if (empty($input['street'])) {
            throw new \InvalidArgumentException("O campo 'Rua' é obrigatório.");
        }

        if (empty($input['neighborhood'])) {
            throw new \InvalidArgumentException("O campo 'Bairro' é obrigatório.");
        }

        if (empty($input['city'])) {
            throw new \InvalidArgumentException("O campo 'Cidade' é obrigatório.");
        }

        if (empty($input['state']) || !preg_match('/^[A-Z]{2}$/', $input['state'])) {
            throw new \InvalidArgumentException("O campo 'Estado' é obrigatório e deve conter duas letras maiúsculas.");
        }

        if (!empty($input['number']) && !is_numeric($input['number'])) {
            throw new \InvalidArgumentException("O campo 'Número' deve ser numérico.");
        }

        if (!empty($input['complement']) && strlen($input['complement']) > 255) {
            throw new \InvalidArgumentException("O campo 'Complemento' não pode exceder 255 caracteres.");
        }
    }
}

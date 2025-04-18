<?php

namespace Src\Controllers;

use Exception;
use Src\Adapters\Repositories\PdoAddressRepository;
use Src\Adapters\Repositories\PdoCustomerRepository;
use Src\Config\DatabaseConfig;
use Src\Core\Entities\CustomerEntity;
use Src\Core\UseCases\AddressDeleteUseCase;
use Src\Core\UseCases\AddressListUseCase;
use Src\Core\UseCases\AddressSaveUseCase;
use Src\Core\UseCases\CustomerDeleteUseCase;
use Src\Core\UseCases\CustomerFindUseCase;
use Src\Core\UseCases\CustomerListUseCase;
use Src\Core\UseCases\CustomerSaveUseCase;

class CustomerController
{
    public function index()
    {
        $pdoConnection = DatabaseConfig::getPdoConnection();
        $repository = new PdoCustomerRepository($pdoConnection);
        $useCase = new CustomerListUseCase($repository);

        try {
            $customers = $useCase->execute();

            return view('customer/index', [
                'title' => 'Clientes',
                'headerTitle' => 'Lista de Clientes',
                'customers' => $customers,
                'icon' => 'fa-users-between-lines',
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function create(array $request)
    {
        return view('customer/form', [
            'title' => 'Cadastrar Cliente',
            'headerTitle' => 'Cadastrar Cliente',
            'icon' => 'fa-users-between-lines',
            'customer' => new CustomerEntity(
                $request['name'] ?? '',
                $request['birth_date'] ?? '',
                $request['cpf'] ?? '',
                $request['rg'] ?? '',
                $request['phone'] ?? '',
            ),
        ]);
    }

    public function edit(array $request)
    {
        try {
            $pdoConnection = DatabaseConfig::getPdoConnection();
            $repository = new PdoCustomerRepository($pdoConnection);
            $useCase = new CustomerFindUseCase($repository, 'id');

            $customer = $useCase->execute($request['id']);

            return view('customer/form', [
                'title' => 'Editar Cliente',
                'headerTitle' => 'Editar Cliente',
                'customer' => $customer,
                'icon' => 'fa-users-between-lines',
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function save(array $request)
    {
        try {
            $pdoConnection = DatabaseConfig::getPdoConnection();
            $repository = new PdoCustomerRepository($pdoConnection);
            $useCase = new CustomerSaveUseCase($repository);

            $useCase->execute($request);

            redirect('/customers');
        } catch (\Throwable $e) {
            $action = isset($request['id']) ? 'edit' : 'create';
            redirect("/customers/$action", array_merge($request, ['errorMessage' => $e->getMessage()]));
        }
    }

    public function saveAddress(array $request)
    {
        try {
            $pdoConnection = DatabaseConfig::getPdoConnection();
            $addressRepository = new PdoAddressRepository($pdoConnection);
            $addressSaveUseCase = new AddressSaveUseCase($addressRepository);

            $addressSaveUseCase->execute($request);

            return responseJson(['success' => 'Endereço salvo com sucesso!'], 200);
        } catch (\Throwable $e) {
            return responseJson(['error' => $e->getMessage()], 500);
        }
    }

    public function delete(array $request)
    {
        try {
            $pdoConnection = DatabaseConfig::getPdoConnection();

            $addressRepository = new PdoAddressRepository($pdoConnection);
            $addressListUseCase = new AddressListUseCase($addressRepository);
            $addressDeleteUseCase = new AddressDeleteUseCase($addressRepository);

            $addresses = $addressListUseCase->execute($request['id']);
            foreach ($addresses as $address) {
                if (!$addressDeleteUseCase->execute($address->getId())) {
                    throw new Exception("Falha ao deletar o endereço do cliente com ID: " . $address->getId());
                }
            }

            $customerRepository = new PdoCustomerRepository($pdoConnection);
            $customerDeleteUseCase = new CustomerDeleteUseCase($customerRepository);

            if (!$customerDeleteUseCase->execute($request['id'])) {
                throw new Exception("Falha ao deletar cliente com ID: " . $request['id']);
            }

            redirect('/customers');
        } catch (\Throwable $e) {
            redirect('/customers', ['errorMessage' => $e->getMessage()]);
        }
    }

    public function getAddresses(array $request)
    {
        try {
            $pdoConnection = DatabaseConfig::getPdoConnection();

            $addressRepository = new PdoAddressRepository($pdoConnection);
            $addressListUseCase = new AddressListUseCase($addressRepository);

            $customerRepository = new PdoCustomerRepository($pdoConnection);
            $customerFindUseCase = new CustomerFindUseCase($customerRepository, 'id');

            $customer = $customerFindUseCase->execute($request['id']);
            $customerAddresses = $addressListUseCase->execute($customer->getId());

            $addresses = [];
            foreach ($customerAddresses as $address) {
                $addresses[] = [
                    'id' => $address->getId(),
                    'customer_id' => $address->getCustomerId(),
                    'street' => $address->getStreet(),
                    'number' => $address->getNumber(),
                    'complement' => $address->getComplement(),
                    'neighborhood' => $address->getNeighborhood(),
                    'city' => $address->getCity(),
                    'state' => $address->getState(),
                    'zip_code' => $address->getZipCode(),
                ];
            }

            $data = [
                'customer' => [
                    'id' => $customer->getId(),
                    'name' => $customer->getName(),
                    'addresses' => $addresses
                ]
            ];

            return responseJson($data, 200);
        } catch (\Throwable $e) {
            return responseJson(['error' => $e->getMessage()], 500);
        }
    }
}

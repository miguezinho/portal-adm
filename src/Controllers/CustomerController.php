<?php

namespace Src\Controllers;

use Src\Adapters\Repositories\PdoCustomerRepository;
use Src\Config\DatabaseConfig;
use Src\Core\Entities\CustomerEntity;
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
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function create()
    {
        return view('customer/form', [
            'title' => 'Cadastrar Cliente',
            'headerTitle' => 'Cadastrar Cliente',
            'customer' => new CustomerEntity('', '', '', '', ''),
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
            redirect('/customers/create?errorMessage=' . urlencode($e->getMessage()));
        }
    }
}

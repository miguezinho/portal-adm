<?php

namespace Src\Controllers;

use Src\Adapters\Repositories\PdoCustomerRepository;
use Src\Config\DatabaseConfig;
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
        return view('customer/create', [
            'title' => 'Cadastrar Cliente',
            'headerTitle' => 'Cadastrar Cliente'
        ]);
    }

    public function save()
    {
        $pdoConnection = DatabaseConfig::getPdoConnection();
        $repository = new PdoCustomerRepository($pdoConnection);

        $data = $_POST;

        try {
            $useCase = new CustomerSaveUseCase($repository);

            $useCase->execute($data);

            redirect('/customers');
        } catch (\Throwable $e) {
            redirect('/customers/create?errorMessage=' . urlencode($e->getMessage()));
        }
    }
}

<?php

namespace Src\Controllers;

use Src\Adapters\Repositories\PdoAddressRepository;
use Src\Adapters\Repositories\PdoCustomerRepository;
use Src\Adapters\Repositories\PdoUserRepository;
use Src\Config\DatabaseConfig;
use Src\Core\UseCases\AddressListUseCase;
use Src\Core\UseCases\CustomerListUseCase;
use Src\Core\UseCases\UserListUseCase;

class DashboardController
{
    public function index()
    {
        try {
            $pdoConnection = DatabaseConfig::getPdoConnection();

            $userRepository = new PdoUserRepository($pdoConnection);
            $userListUseCase = new UserListUseCase($userRepository);
            $users = $userListUseCase->execute();

            $customerRepository = new PdoCustomerRepository($pdoConnection);
            $customerListUseCase = new CustomerListUseCase($customerRepository);
            $customers = $customerListUseCase->execute();

            $addressRepository = new PdoAddressRepository($pdoConnection);
            $addressListUseCase = new AddressListUseCase($addressRepository);
            $addresses = $addressListUseCase->execute();

            return view('dashboard/index', [
                'headerTitle' => 'Dashboard',
                'title' => 'Dashboard',
                'icon' => 'fa-tachometer',
                'usersCount' => count($users),
                'customersCount' => count($customers),
                'addressesCount' => count($addresses),
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}

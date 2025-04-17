<?php

namespace Src\Controllers;

class CustomerController
{
    public function index()
    {
        return view('customer/index', [
            'headerTitle' => 'Clientes',
            'title' => 'Clientes'
        ]);
    }
}

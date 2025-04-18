<?php

namespace Src\Controllers;

class DashboardController
{
    public function index()
    {
        return view('dashboard/index', [
            'headerTitle' => 'Dashboard',
            'title' => 'Dashboard',
            'icon' => 'fa-tachometer'
        ]);
    }
}

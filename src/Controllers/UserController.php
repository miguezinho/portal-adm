<?php

namespace Src\Controllers;

class UserController
{
    public function index()
    {
        return view('user/index', [
            'headerTitle' => 'Usuários',
            'title' => 'Usuários'
        ]);
    }
}

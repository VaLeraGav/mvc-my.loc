<?php

namespace App\Controllers;

use App\Application\Views\View;

class LoginController
{
    public function destroy(): void
    {
        View::show('pages/index', [
            'title' => 'destroy'
        ]);
    }

    public function index(): void
    {
        View::show('pages/index', [
            'title' => 'LoginController: index'
        ]);
    }
}
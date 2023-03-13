<?php

namespace App\Controllers;

use Core\Base\View;

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
<?php

namespace App\Controllers;

use App\Application\Views\View;

class RegistrationController
{
    public function index(): void
    {
        View::show('pages/index', [
            'title' => 'RegistrationController: Home'
        ]);
    }

    public function registration(): void
    {
        View::show('pages/index', [
            'title' => 'registration'
        ]);
    }

}
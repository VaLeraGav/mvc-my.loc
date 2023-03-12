<?php

namespace App\Controllers;

use App\Application\Views\View;

class ServicesController
{
    public function contacts(): void
    {
        View::show('pages/index', [
            'title' => 'contacts'
        ]);
    }

    public function index(): void
    {
        View::show('pages/index', [
            'title' => 'ServicesController: index'
        ]);
    }

    public function auth(): void
    {
        View::show('pages/index', [
            'title' => 'auth'
        ]);
    }
}
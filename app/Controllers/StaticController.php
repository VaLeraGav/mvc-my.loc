<?php

namespace App\Controllers;

use App\Application\Views\View;

class StaticController
{
    public function index(): void
    {
        View::show('pages/index', [
            'title' => 'StaticController: Home'
        ]);
    }

    public function about(): void
    {
        View::show('pages/index', [
            'title' => 'about'
        ]);
    }

    public function close(): void
    {
        View::show('pages/index', [
            'title' => 'close'
        ]);
    }
}
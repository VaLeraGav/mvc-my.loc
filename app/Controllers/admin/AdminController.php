<?php

namespace App\Controllers\admin;

use Core\Base\Controller;
use Core\Base\View;

class AdminController extends Controller
{
    public $layout = 'admin';

    public function index(): void
    {
        $this->view('pages/index', [
            'title' => 'Home'
        ]);
    }
}
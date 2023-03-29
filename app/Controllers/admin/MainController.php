<?php

namespace App\Controllers\admin;

use App\Controllers\admin\AppController;

class MainController extends AppController
{

    public function index(): void
    {
        $this->setMeta('Панель управления');

        $this->view('admin/pages/index');
    }
}
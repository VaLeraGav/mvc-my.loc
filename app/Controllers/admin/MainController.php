<?php

namespace App\Controllers\admin;

use Core\Base\Model;

class MainController extends AppController
{
    public function index(): void
    {
        $this->setMeta('Панель управления');

        $countNewOrders = Model::count('order', "status = '0'");

        $countUsers = Model::count('user');

        $countProducts = Model::count('product');

        $countCategories = Model::count('category');

        $this->view(
            'admin/pages/index',
            [
                'countNewOrders' => $countNewOrders,
                'countUsers' => $countUsers,
                'countProducts' => $countProducts,
                'countCategories' => $countCategories
            ]
        );
    }
}
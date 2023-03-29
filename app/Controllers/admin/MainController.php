<?php

namespace App\Controllers\admin;

use Core\Base\Model;

class MainController extends AppController
{
    public function index(): void
    {
        $this->setMeta('Панель управления');

        // TODO: переписать в отдельный метод
        $orders = Model::requestArr("SELECT COUNT(*) FROM `order` WHERE status = '0'");
        $countNewOrders = $orders[0]['COUNT(*)'];

        $user = Model::requestArr("SELECT COUNT(*) FROM `user`");
        $countUsers = $user[0]['COUNT(*)'];

        $product = Model::requestArr("SELECT COUNT(*) FROM `product`");
        $countProducts = $product[0]['COUNT(*)'];

        $categories = Model::requestArr("SELECT COUNT(*) FROM `category`");
        $countCategories = $categories[0]['COUNT(*)'];

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
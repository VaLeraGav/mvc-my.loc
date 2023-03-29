<?php

namespace App\Controllers\admin;

use App\Models\OrderModel;
use Core\Base\Model;
use Core\Libs\Pagination;
use Core\Logger;

class OrderController extends AppController
{

    public function index(): void
    {
        $this->setMeta('Cписок заказов');

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 10;
        $orders = Model::requestArr("SELECT COUNT(*) FROM `order`");
        $countOrders = $orders[0]['COUNT(*)'];
        $pagination = new Pagination($page, $perpage, $countOrders);
        $start = $pagination->getStart();

        $orders = Model::requestArr(
            "SELECT `order`.`id`, `order`.`user_id`, `order`.`status`, `order`.`date`, `order`.`update_at`, `order`.`currency`, `user`.`name`, 
                    ROUND(SUM(`order_product`.`price`), 2) AS `sum` 
                    FROM `order` 
                    JOIN `user` ON `order`.`user_id` = `user`.`id`
                    JOIN `order_product` ON `order`.`id` = `order_product`.`order_id`
                    GROUP BY `order`.`id` 
                    ORDER BY `order`.`status`, `order`.`id` 
                    LIMIT $start, $perpage"
        );

        // создание индекса
        //  $ex1 = Model::requestArr("CREATE INDEX index_test1 ON `order` (`id`)");
        //  $ex2 = Model::requestArr("CREATE INDEX index_test2 ON `order` (`status`)");
        //  $ex = Model::requestArr(" DROP INDEX index_test ON `order`");
        //  $sql = Model::requestArr("SHOW INDEX FROM `order`");


        $this->view('admin/order/index', [
            'pagination' => $pagination,
            'orders' => $orders
        ]);
    }

    public function viewAction(): void
    {
        $order_id = $this->getRequestID();

        $orders = Model::requestArr(
            "SELECT `order`.*, `user`.`name`,
                    ROUND(SUM(`order_product`.`price`), 2) AS `sum`
                    FROM `order`
                    JOIN `user` ON `order`.`user_id` = `user`.`id`
                    JOIN `order_product` ON `order`.`id` = `order_product`.`order_id`
                     WHERE `order`.`id` = $order_id
                    GROUP BY `order`.`id`
                    ORDER BY `order`.`status`, `order`.`id`
                    LIMIT 1"
        );

        $order = $orders[0];
        if (empty($order)) {
            throw new \Exception('Страница не найдена', 404);
        }

        $order_products = Model::requestObj("SELECT * FROM `order_product` WHERE order_id = $order_id");

        $this->view('admin/order/view', [
            'order' => $order,
            'order_products' => $order_products
        ]);
    }

    public function change()
    {
        $order_id = $this->getRequestID();
        $status = $this->getRequestID(true, 'status');

        $update_at = date("Y-m-d H:i:s");

        Model::requestObj(
            "UPDATE `order` SET status = '$status', update_at = '$update_at' WHERE `order`.id = $order_id"
        );

        $_SESSION['success'] = 'Изменения сохранены';
        redirect();
    }

    public function delete()
    {
        $order_id = $this->getRequestID();

        Model::requestObj(
            " DELETE FROM `order` WHERE `order`.id = $order_id"
        );

        $_SESSION['success'] = 'Заказ успешно удален';
        redirect(ADMIN . '/order');
    }
}

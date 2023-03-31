<?php

namespace App\Models;

use Core\Base\Model;

class OrderModel extends Model
{

    public string $table = 'order';

    public array $attributes = [
        'user_id' => '',
        'currency' => '',
        'note' => '',
    ];

    public function saveOrder($data)
    {
        $this->attributes['user_id'] = $data['user_id'];
        $this->attributes['note'] = $data['note'];
        $this->attributes['currency'] = $_SESSION['cart.currency']['code'];

        $order_id = $this->save();

        $this->saveOrderProduct($order_id);
        return $order_id;
    }

    public function saveOrderProduct($order_id)
    {
        $sql_part = '';
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product_id => $product) {
                $product_id = (int)$product_id;
                $sql_part .= "($order_id, $product_id, {$product['qty']}, '{$product['title']}', {$product['price']}),";
            }
            $sql_part = rtrim($sql_part, ',');
            Model::queryNew(
                "INSERT INTO order_product (order_id, product_id, qty, title, price) VALUES $sql_part"
            );
            unset($_SESSION['cart']);
            unset($_SESSION['cart.qty']);
            unset($_SESSION['cart.sum']);
            unset($_SESSION['cart.sum']);

            // в самом конце
            // TODO: реализовать транзакцию
            $_SESSION['success'] = 'Thank you for your order. In the near future, a manager will contact you to coordinate the order.';
        }
    }

    public static function mailOrder($order_id, $user_email)
    {
        // отправка на email
    }
}
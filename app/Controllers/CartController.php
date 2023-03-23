<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\UserModel;
use Core\App;
use Core\Base\Model;
use Core\Cache;
use Core\Connection;

use function PHPUnit\Framework\throwException;

class CartController extends AppController
{
    public function add()
    {
        $id = !empty($_GET['id']) ? (int)$_GET['id'] : null;
        $qty = !empty($_GET['qty']) ? (int)$_GET['qty'] : null;
        $mod_id = !empty($_GET['mod']) ? (int)$_GET['mod'] : null;
        $mod = null;
        if ($id) {
            $product = Model::requestObj("SELECT * FROM product WHERE id = '{$id}'");
            if (!$product) {
                return false;
            }
            if ($mod_id) {
                $mod = Model::requestObj("SELECT * FROM modification WHERE id = '{$mod_id}' AND product_id = '{$id}'");
            }
        };

        $cart = new CartModel();
        $cart->addToCart($product[0], $qty, $mod);
        if ($this->isAjax()) {
            $this->loadView('cart/cart_modal');
        }
        redirect();
    }

    public function show()
    {
        $this->loadView('cart/cart_modal');
    }

    public function delete()
    {
        $id = !empty($_GET['id']) ? $_GET['id'] : null;
        if (isset($_SESSION['cart'][$id])) {
            $cart = new CartModel();
            $cart->deleteItem($id);
        }
        if ($this->isAjax()) {
            $this->loadView('cart/cart_modal');
        }
        redirect();
    }

    public function clear()
    {
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
        unset($_SESSION['cart.currency']);
        $this->loadView('cart/cart_modal');
    }

}
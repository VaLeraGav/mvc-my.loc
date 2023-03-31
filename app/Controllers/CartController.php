<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\OrderModel;
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
            $product = Model::requestObj('product', 'WHERE id = ? ', [$id]);
            if (!$product) {
                return false;
            }
            if ($mod_id) {
                $mod = Model::requestObj('modification', 'WHERE id = ? AND product_id = ?', [$mod_id, $id]);
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

    public function viewAction($data = [])
    {
        $this->setMeta('Cart');

        $this->view('cart/view', [
            'data' => $data,
        ]);
    }

    public function checkout($request)
    {
        $this->setMeta('Cart');

        $user = new UserModel();
        if (!UserModel::isAuth()) {
            $user->load($request, ['password_confirmation', 'note']);
            $errors = $user->validate($request);

            if (!empty($errors)) {
                $this->view('cart/view', [
                    'users' => $user->attributes,
                    'errors' => $errors
                ]);
            } else {
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                $user->save();
                $user->addAuth();
            }
        }
        $user_id = $user->find('email', $_SESSION['user']['email'])['id'];
        $user_email = $_SESSION['user']['email'] ?? $_POST['email'];

        $data['user_id'] = ($user_id) ? $user_id : 1;
        $data['note'] = !empty($request['note']) ? $request['note'] : '';

        $order = new OrderModel();
        $order_id = $order->saveOrder($data);

        // $order->mailOrder($order_id, $user_email);

        redirect();
    }
}

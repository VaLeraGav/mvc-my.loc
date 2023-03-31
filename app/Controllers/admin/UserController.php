<?php

namespace App\Controllers\admin;

use App\Models\UserModel;
use Core\Base\Model;
use Core\Libs\Pagination;
use Core\Logger;

class UserController extends AppController
{

    public function index($login = '', $message = '')
    {
        $this->layout = 'loginAdmin';
        $this->view('admin/user/login', [
            'login' => $login,
            'message' => $message
        ]);
    }

    public function login($request)
    {
        $this->layout = 'loginAdmin';
        $user = new UserModel();

        $user->load($request);

        if ($user->checkLogin(true)) {
            $message = 'Вы успешно авторизованы';
        } else {
            $message = 'Аккаунт не найден';
        }

        if ($user::isAdmin()) {
            redirect(ADMIN);
        } else {
            $this->view('admin/user/login', [
                'login' => $user->attributes['email'],
                'message' => $message
            ]);
        }
    }

    public function show()
    {
        $this->setMeta('Список пользователей');

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 10;

        $count = Model::count('user');
        $pagination = new Pagination($page, $perpage, $count);
        $start = $pagination->getStart();

        $users = Model::requestObj('user', "LIMIT $start, $perpage");

        $this->view('admin/user/show', [
            'users' => $users,
            'pagination' => $pagination,
            'count' => $count
        ]);
    }

    public function edit()
    {
        $this->setMeta('Редактирование профиля пользователя');

        $user_id = $this->getRequestID();

        $user = new UserModel();
        $user = $user->find('id', $user_id);

        $orders = Model::queryNew(
            "SELECT `order`.`id`, `order`.`user_id`, `order`.`status`, `order`.`date`, `order`.`update_at`, `order`.`currency`, 
                             ROUND(SUM(`order_product`.`price`), 2) AS `sum` FROM `order`
                             JOIN `order_product` ON `order`.`id` = `order_product`.`order_id` WHERE user_id = {$user_id}
                             GROUP BY `order`.`id` ORDER BY `order`.`status`, `order`.`id`"
        );

        $this->view('admin/user/edit', [
            'user' => $user,
            'orders' => $orders
        ]);
    }

    public function update($request)
    {
        $this->setMeta('Редактирование профиля пользователя');
        $id = $this->getRequestID(false);

        $user = new \App\Models\admin\UserModel();
        $user->load($request);

        $user->hasErrors($request);
        $user->uniqueEmail();

        if (!empty($user->errors)) {
            $_SESSION['val'] = $user->errors;
            redirect("/admin/user/edit?id=$id");
        } else {
            $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
            $user->updatetGetModel($id);

            $_SESSION['success'] = 'Пользователь изменен';
            unset($_SESSION['val']);
            redirect();
        }
    }


    public function add()
    {
        $this->setMeta('Добавить пользователя');

        $this->view('admin/user/add');
    }

    public function signup($request)
    {
        $user = new UserModel();

        $user->load($request);
        $user->hasErrors($request);
        $user->uniqueEmail();

        if (!empty($user->errors)) {
            $this->view('admin/user/add', [
                'users' => $user->attributes,
                'errors' => $user->errors
            ]);
        } else {
            $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
            $user->save();

            $_SESSION['success'] = 'Пользователь успешно добавлен';
            redirect();
        }
    }

}

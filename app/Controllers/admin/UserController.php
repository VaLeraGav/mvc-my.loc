<?php

namespace App\Controllers\admin;

use App\Models\UserModel;

class UserController extends AppController
{
    public $layout = 'loginAdmin';

    public function index($login = '', $message = '')
    {
        $this->view('admin/pages/login', [
            'login' => $login,
            'message' => $message
        ]);
    }

    public function login($request)
    {
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
            $this->view('admin/pages/login', [
                'login' => $user->attributes['email'],
                'message' => $message
            ]);
        }
    }

}

<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends AppController
{
    public function index($login = '', $message = '')
    {
        $this->setMeta('Вход');

        $this->view('pages/login', [
            'login' => $login,
            'message' => $message
        ]);
    }

    public function login($request)
    {
        $auth = new UserModel();

        $auth->load($request);

        if (!empty($auth->checkLogin($request['email']))) {
            $message = 'Аккаунт авторизован';
            $auth->addAuth($auth->attributes['email']);
            redirect('/');
        } else {
            $message = 'Аккаунт не найден';
        }
        $this->view('pages/login', ['login' => $auth->attributes['email'], 'message' => $message]);
    }

    public function destroy()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }

        session_destroy();
        redirect('/');
    }

}
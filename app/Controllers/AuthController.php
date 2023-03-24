<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends AppController
{
    public function index($email = '', $error = '')
    {
        $this->setMeta('Вход');

        $this->view('pages/login', [
            'email' => $email,
            'error' => $error
        ]);
    }

    public function login($request)
    {
        $auth = new UserModel();

        $email = $request['email'];
        $password = $request['password'];
        $error = '';

        if (!empty($auth->checkLogin($email, $password))) {
            $login = $auth->query("SELECT login FROM user WHERE email = '$email'")->fetchAll();
            $auth->addAuth($login[0]['login']);
            $_SESSION['success'] = 'You are successfully logged in';
        } else {
            $error = 'Account not found';
        }
        $this->view('pages/login', ['email' => $email, 'error' => $error]);
    }

    public function destroy()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
        session_destroy();
        redirect();
    }

}
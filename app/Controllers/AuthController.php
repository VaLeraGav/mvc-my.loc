<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends AppController
{
    public function index($email = '')
    {
        $this->setMeta('Вход');

        $this->view('pages/login', [
            'email' => $email
        ]);
    }

    public function login($request)
    {
        $auth = new UserModel();

        $auth->load($request);

        if ($auth->checkLogin()) {
            $_SESSION['success'] = 'You are successfully logged in';
        } else {
            $_SESSION['error'] = 'Account not found';
        }

        $this->view('pages/login', ['email' => $auth->attributes['email']]);
    }

    public function destroy()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
        redirect();
    }
}
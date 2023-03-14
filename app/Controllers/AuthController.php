<?php

namespace App\Controllers;

use Core\Base\Controller;
use Core\Base\View;

class AuthController extends Controller
{
    public function index($login = [], $message = [])
    {
        $this->view('pages/login', ['login' => $login, 'message' => $message]);
    }

    public function login($request)
    {
        [
            'email' => $email,
            'password' => $password,
        ] = $request;

        $this->view('pages/login', ['email' => $email, 'message' => $password]);
    }

    public function destroy()
    {
        unset($_SESSION);
        session_destroy();

        $this->view('pages/index');
    }


}
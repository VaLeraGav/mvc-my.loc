<?php

namespace App\Controllers;

use App\Models\UserModel;
use Core\Base\Controller;
use Core\Base\View;
use Core\Connection;

class RegistrationController extends Controller
{
    public function index($data = []): void
    {
         $this->view('pages/register', [
            'data' => $data
        ]);
    }

    public function registration($post): void
    {
        [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password_confirmation
        ] = $post;

        $mode = new UserModel();

        $userModel = $mode->query('SELECT * FROM users')->fetchAll();

        $this->view('pages/register', [
            'users' => $post,
            'errors' => $userModel
        ]);
    }

}
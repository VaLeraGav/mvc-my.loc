<?php

namespace App\Controllers;

use App\Models\UserModel;
use Core\Base\Controller;
use Core\Base\View;
use Core\Connection;
use Core\Validator;

class RegistrationController extends Controller
{
    public function index($data = []): void
    {
        $this->view('pages/register', [
            'data' => $data
        ]);
    }

    public function registration($post)
    {
        $this->setMeta('Регистрация');


        [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password_confirmation
        ] = $post;

        $user = new UserModel();

        // $user->load($post);

        $errors = $user->validate($post);

        if (!empty($errors)) {
            $user->insertGetModel([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            $this->view('pages/register', [
                'users' => $post,
                'errors' => $errors
            ]);

        } else {

            redirect('/');
        }
    }

}
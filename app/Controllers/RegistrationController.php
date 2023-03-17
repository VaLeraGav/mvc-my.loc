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

        $user = new UserModel();

        $user->load($post, ['password_confirmation']);

        $errors = $user->validate($post);

        if (!empty($errors)) {
            $this->view('pages/register', [
                'users' => $post,
                'errors' => $errors
            ]);
        } else {
            $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
            $user->save();
            redirect('/');
        }
    }

}
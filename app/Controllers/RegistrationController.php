<?php

namespace App\Controllers;

use App\Models\UserModel;

class RegistrationController extends AppController
{
    public function index($data = []): void
    {
        $this->setMeta('Регистрация');

        $this->view('pages/register', [
            'data' => $data
        ]);
    }

    public function registration($request)
    {
        $user = new UserModel();

        $user->load($request, ['password_confirmation']);

        $errors = $user->validate($request);
        if (!empty($errors)) {
            $this->view('pages/register', [
                'users' => $user->attributes,
                'errors' => $errors
            ]);
        } else {
            $_SESSION['success'] = 'You are successfully registered';

            $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
            $user->save();
            $user->addAuth();
            redirect();
        }
    }
}
<?php

namespace App\Controllers;

use App\Models\UserModel;
use Core\Base\Model;

class RegistrationController extends AppController
{
    public function index(): void
    {
        $this->setMeta('Регистрация');

        $this->view('pages/register');
    }

    public function signup($request)
    {
        $user = new UserModel();

        $user->load($request);
        $user->hasErrors($request);
        $user->uniqueEmail();

        if (!empty($user->errors)) {
            $this->view('pages/register', [
                'users' => $user->attributes,
                'errors' => $user->errors
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
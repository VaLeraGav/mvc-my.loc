<?php

namespace App\Models;

use Core\Base\Model;
use Core\Logger;

class UserModel extends Model
{
    public string $table = 'user';

    public array $attributes = [
        'login' => '',
        'password' => '',
        'email' => '',
        'name' => '',
        'address' => '',
        'role' => 'user',
    ];

    public array $rules = [
        'login' => 'require|max:30|min:3',
        'name' => 'require|max:30|min:3',
        'email' => 'require|email',
        'address' => 'require|min:3',
        'password' => 'require',
        'password_confirmation' => 'require|match:password'
    ];

//    public array $rulesMessage = [
//        'name' => [
//            'require' =>
//                'Имя не должно быть пустым',
//            'max' =>
//                'Имя не должно превышать :max символов',
//            'min' =>
//                'Имя не должно быть меньше :min символов',
//            'unique' =>
//                'Имя должно быть уникальным',
//        ]
//    ];

    /**
     * Поверяет существования пользователь и если существует записывает в сессию
     */
    public function checkLogin($isAdmin = false): bool
    {
        $email = !empty(trim($this->attributes['email'])) ? trim($this->attributes['email']) : null;
        $password = !empty(trim($this->attributes['password'])) ? trim($this->attributes['password']) : null;
        if ($email && $password) {
            if ($isAdmin) {
                $user = Model::requestArr("user", "WHERE email = ? AND role = 'admin'", [$email]);
                $user = empty($user) ? false : $user[0];
            } else {
                $user = $this->find('email', $email);
            }

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    foreach ($user as $k => $v) {
                        if ($k != 'password') {
                            $_SESSION['user'][$k] = $v;
                        }
                    }
                    return true;
                }
            }
        }
        return false;
    }

    public function uniqueEmail()
    {
        $user = $this->find('email', $this->attributes['email']);
        if ($user) {
            if ($user['email'] == $this->attributes['email']) {
                $this->errors['email'][] = 'This email is already taken';
            }
            return false;
        }
        return true;
    }

    /**
     * Авторизация пользователя, записывает в сессию
     */
    public function addAuth()
    {
        foreach ($this->attributes as $k => $v) {
            if ($k != 'password') {
                $_SESSION['user'][$k] = $v;
            }
        }
        return null;
    }

    /**
     * Возвращает авторизован пользователь или нет
     */
    public static function isAuth()
    {
        return isset($_SESSION['user']);
    }

    public static function isAdmin()
    {
        return (isset($_SESSION['user'])) && $_SESSION['user']['role'] == 'admin';
    }

    /**
     * Возвращает логин авторизованного пользователя
     */
    public static function getLogin()
    {
        if (self::isAuth()) {
            return $_SESSION['user']["login"];
        }
        return null;
    }
}

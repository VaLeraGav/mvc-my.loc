<?php

namespace App\Models;

use Core\Base\Model;

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
        'login' => 'require|max:30|min:3|unique',
        'name' => 'require|max:30|min:3',
        'email' => 'require|email',
        'address' => 'require|min:3',
        'password' => 'require|match:password_confirmation',
        'password_confirmation' => 'require'
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
     * Поверяет существования пользователь
     */
    public function checkLogin($email, $password): bool
    {
        $email = !empty(trim($email)) ? trim($email) : null;
        $password = !empty(trim($password)) ? trim($password) : null;

        if ($email && $password) {
            $user = $this->find('email', $email); // достаем по логину пользователя
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Авторизация пользователя
     */
    public function addAuth($login)
    {
        $_SESSION['user']["is_auth"] = true;
        $_SESSION['user']["login"] = $login;
        return null;
    }

    /**
     * Возвращает авторизован пользователь или нет
     */
    public static function isAuth()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user']["is_auth"];
        } else {
            return false;
        }
    }

    /**
     * Возвращает логин авторизованного пользователя
     */
    public static function getLogin()
    {
        if (self::isAuth()) { //Если пользователь авторизован
            return $_SESSION['user']["login"]; //Возвращаем логин, который записан в сессию
        }
        return null;
    }
}

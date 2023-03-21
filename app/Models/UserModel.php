<?php

namespace App\Models;

use Core\Base\Model;

class UserModel extends Model
{
    public string $table = 'users';

    public array $attributes = [
        'login' => '',
        'password' => '',
        'email' => '',
        'name' => '',
        'address' => '',
        'role' => '',
        'created_at' => '',
        'update_at' => '',
    ];

    public array $rules = [
        'name' => 'require|max:30|min:3|unique',
        'email' => 'require|email',
        'password' => 'require|match:password_confirmation',
        'password_confirmation' => 'require'
    ];

    public array $rulesMessage = [
        'name' => [
            'require' =>
                'Имя не должно быть пустым',
            'max' =>
                'Имя не должно превышать :max символов',
            'min' =>
                'Имя не должно быть меньше :min символов',
            'unique' =>
                'Имя должно быть уникальным',
        ]
    ];

    /**
     * Поверяет существования пользователь
     */
    public function checkLogin($email): bool
    {
        $email = !empty(trim($email)) ? trim($email) : null;
        $password = !empty(trim($this->attributes['password'])) ? trim($this->attributes['password']) : null;

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

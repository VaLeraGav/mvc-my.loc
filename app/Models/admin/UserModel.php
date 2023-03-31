<?php

namespace App\Models\admin;

class UserModel extends \App\Models\UserModel
{
    public string $table = 'user';

    public array $attributes = [
        'id' => '',
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
        'role' => 'require',
    ];


    public function uniqueEmail()
    {
        $user = UserModel::requestArr(
            'user', 'WHERE email = ? AND id <> ?',
            [$this->attributes['email'], $this->attributes['id']]
        );

        if (!empty($user)) {
            $user = $user[0];
            if ($user['email'] == $this->attributes['email']) {
                $this->errors['email'][] = 'This email is already taken';
            }
            return false;
        }
        return true;
    }
}
<?php

namespace App\Models;

use Core\Base\Model;

class UserModel extends Model
{
    public string $table = 'users'; // как таблица

    public string $pk = 'category_id'; // теперь по умолчанию у нас в findOne будет не id поиск а по заданному полю

    public array $attributes = [
        'name' => '',
        'email' => '',
        'password' => '',
        'created_at' => '',
        'update_at' => '',
    ];

    public array $rules = [
        'name' => 'require|max:30|min:1|unique',
        'email' => 'require|email',
        'password' => 'require|match:password_confirmation',
        'password_confirmation' => 'require'
    ];

}

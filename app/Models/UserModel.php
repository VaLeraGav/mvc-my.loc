<?php

namespace App\Models;

use Core\Base\Model;

class UserModel extends Model
{
    public string $table = 'users'; // как таблица

    // public string $pk = 'category_id'; // теперь по умолчанию у нас в findOne будет не id поиск а по заданному полю

    public array $attributes = [
        'name',
        'email',
        'password',
        'created_at',
        'update_at'
    ];

    public array $rules = [
        'name' => 'require|max:30|min:1|unique',
        'email' => 'require|email',
        'password' => 'require|match:password_confirmation',
        'password_confirmation' => 'require'
    ];

    public function insertGetModel($dataUser)
    {
        $filds = array_diff($this->attributes, ['created_at', 'update_at']);

        $strFilds = implode(', ', $filds);

        // TODO: доделать, чтобы можно было ставить в Model

        $sql = "INSERT INTO {$this->table} ({$strFilds}) VALUES
            (:name, :email, :password)";
        $params = [
            ':name' => $dataUser['name'],
            ':email' => $dataUser['email'],
            ':password' => $dataUser['password'],
        ];

        $this->query($sql, $params);
    }

}

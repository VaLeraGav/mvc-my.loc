<?php

namespace App\Models;

use App\Application\Database\Model;

class UserModel extends Model
{
    public string $table ='user'; // как таблица

    // public string $pk = 'category_id'; // теперь по умолчанию у нас в findOne будет не id поиск а по заданному полю

    // дает гибкость при обращении к полям
    public array $attributes = [
        'name' => '',
        'position' => '',
        'birthday' => '',
    ];

}

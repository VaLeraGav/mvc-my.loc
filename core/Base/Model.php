<?php

namespace Core\Base;

use Core\Connection;
use Core\Validator;

abstract class Model
{
    protected string $table; // имя таблицы
    protected string $pk = 'id'; // первичный ключ
    public array $attributes = []; // // атрибуты для модели

    public array $rules;
    private $connect;

    public function __construct()
    {
        $db = Connection::connectInstance();
        $this->connect = $db->otherConnect();
    }

    public function getConnect(): \PDO
    {
        return $this->connect;
    }


    public static function setup(): \PDO
    {
        return (Connection::connectInstance())->connection();
    }

    public function query(string $sql, array $params = null)
    {
        if (!$params) {
            return $this->connect->query($sql);
        }
        $connect = $this->connect->prepare($sql);
        $result = $connect->execute($params);

        if (!$result) {
            throw new \Exception('Не верный запрос');
        }
        return $connect;
    }

    // возвращает все данные из таблицы
    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->connect->query($sql);
    }

    //-------
    // строить attributes через post
    public function load($data)
    {
        foreach ($this->attributes as $name) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    public function validate($data)
    {
        $validator = new Validator();

        $validator->setRules($this->rules);

        return $validator->validate($data);
    }

    public function find($key, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE " . $key . " = :value";
        $search = $this->query($sql, [':value' => $value])->fetch();

        return empty($search) ? false : $search;
    }

}
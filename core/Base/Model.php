<?php

namespace Core\Base;

use Core\Connection;

abstract class Model
{
    protected string $table; // имя таблицы
    protected string $pk = 'id'; // первичный ключ
    public array $attributes = []; // // атрибуты для модели

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


}
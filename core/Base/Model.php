<?php

namespace Core\Base;

use Core\Connection;

abstract class Model
{
    protected string $table; // имя таблицы
    protected string $pk = 'id'; // первичный ключ
    public array $attributes = []; // // атрибуты для модели

    private \PDO $connect;

    public function __construct()
    {
        // $this->connect = Connection::instance();
        $db = new Connection();
        $this->connect = $db->connect();
    }

    // для удобного статического обращения
    public static function setup(): \PDO
    {
        $db = new Connection();
        return $db->connect();
    }

    public function query(string $sql, array $params = null)
    {
        if (!$params) {
            return $this->connect->query($sql);
        }
        $connect = $this->connect->prepare($sql);
        $result = $connect->execute($params);

        if (!$result) {
            throw new \Exception('не верный запрос');
        }
        return $connect;
    }

    // возвращает все данные из таблицы
    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->connect->query($sql);
    }


    // TODO: описать основные методы для моделей

}
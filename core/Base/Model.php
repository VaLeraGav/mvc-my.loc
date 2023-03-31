<?php

namespace Core\Base;

use Core\Connection;
use Core\Validator;
use Exception;

abstract class Model
{
    use ModelHelper;

    protected string $table; // имя таблицы
    protected string $pk = 'id'; // первичный ключ

    public array $attributes = []; // // атрибуты для модели
    public array $rules;
    public array $rulesMessage;

    private \PDO $connect;

    public function __construct()
    {
        $db = Connection::connectInstance();
        $this->connect = $db->connection();
    }

    public static function setup(): \PDO
    {
        return (Connection::connectInstance())->connection();
    }

    public static function changeKey($data, $key = '')
    {
        foreach ($data as $arr) {
            $cur = $arr[$key];
            $new[$cur] = $arr;
        }
        return $new;
    }

    public static function count($table, $addSQL = '', $bindings = [])
    {
        if (!empty($addSQL)) {
            $sql = "SELECT COUNT(*) FROM `{$table}` WHERE $addSQL";
            $sth = self::setup()->prepare($sql);
            $sth->execute($bindings);
        } else {
            $sql = "SELECT COUNT(*) FROM `{$table}`";
            $sth = self::setup()->query($sql);
        }
        $countArr = $sth->fetchAll();
        return $countArr[0]['COUNT(*)'];
    }

    public static function requestObj($table, $addSQL = '', $bindings = []): array
    {
        $sth = self::request($table, $addSQL, $bindings);

        $arr = $sth->fetchAll();
        return makeObj($arr);
    }

    public static function requestArr($table, $addSQL = '', $bindings = [], $key = '')
    {
        $sth = self::request($table, $addSQL, $bindings);

        $arr = $sth->fetchAll();
        if (!empty($key)) {
            return self::changeKey($arr, $key);
        }
        return $arr;
    }

    public static function request($table, $addSQL = '', $bindings = [])
    {
        if (!empty($addSQL)) {
            $sql = "SELECT * FROM `{$table}`$addSQL";
        } else {
            $sql = "SELECT * FROM `{$table}`";
        }
        if (!$bindings) {
            return self::setup()->query($sql);
        }
        $prep = self::setup()->prepare($sql);
        $prep->execute($bindings);
        return $prep;
    }

    public static function queryNew($sql, $params = [])
    {
        if (!$params) {
            return self::setup()->query($sql)->fetchAll();
        }
        $prep = self::setup()->prepare($sql);
        $prep->execute($params);
        return $prep->fetchAll();
    }
}

<?php

namespace Core\Base;

use Core\Connection;
use Core\Validator;
use Exception;

abstract class Model
{
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

    public function getConnect(): \PDO
    {
        return $this->connect;
    }

    public static function setup(): \PDO
    {
        return (Connection::connectInstance())->connection();
    }

    public static function requestObj($sql, $key = '')
    {
        $arrays = self::setup()->query($sql)->fetchAll();
        if (!empty($key)) {
            return self::changeKey($arrays, $key);
        }
        return makeObj($arrays);
    }

    public static function requestArr($sql, $key = '')
    {
        $arrays = self::setup()->query($sql)->fetchAll();
        if (!empty($key)) {
            return self::changeKey($arrays, $key);
        }
        return $arrays;
    }

    protected static function changeKey($arrays, $key = '')
    {
        foreach ($arrays as $arr) {
            $cur = $arr[$key];
            $newCurr[$cur] = $arr;
        }
        return $newCurr;
    }

    /**
     * Пользовательская query
     */
    public function query($sql, array $params = null)
    {
        try {
            if (!$params) {
                return $this->connect->query($sql);
            }
            $connect = $this->connect->prepare($sql);
            $connect->execute($params);
        } catch (Exception $e) {
            throw new Exception("Не верный запрос {$sql}");
        }
        return $connect;
    }

    /**
     * Возвращает все данные из таблицы
     */
    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->connect->query($sql)->fetchAll();
    }

    /**
     * Объявляет поля у метода
     *
     */
    public function load($PostData, $ignores = []): void
    {
        $removeFields = array_filter($PostData, function ($name) use ($ignores) {
            return !in_array($name, $ignores);
        }, ARRAY_FILTER_USE_KEY);

        foreach ($removeFields as $name => $value) {
            if (isset($PostData[$name])) {
                $this->attributes[$name] = $PostData[$name];
            }
        }
    }

    /**
     * Запустите проверки и возвращает массив ошибок
     */
    public function validate(array $data): array
    {
        $validator = new Validator();

        $validator->setRules($this->rules);
        $validator->setRuleMessage($this->rulesMessage);

        return $validator->validate($data);
    }

    /**
     * Поиск строки
     */
    public function find(string $key, string $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE " . $key . " = :value";
        $search = $this->query($sql, [':value' => $value])->fetch();

        return empty($search) ? false : $search;
    }

    /**
     * Вставка в Модель с явно указанными переменными
     */
    public function insertGetModel(array $dataUser): void
    {
        $ignores = ['created_at', 'update_at'];

        $fields = array_filter($this->attributes, function ($name) use ($ignores) {
            return !in_array($name, $ignores);
        }, ARRAY_FILTER_USE_KEY);

        $keysFields = implode(', ', array_keys($fields));

        foreach ($fields as $k => $v) {
            $params[':' . $k] = $dataUser[$k];
        }

        $strParams = implode(', ', array_keys($params));

        $sql = "INSERT INTO {$this->table} ({$keysFields}) VALUES ({$strParams})";

        $this->query($sql, $params);
    }

    /**
     * Сохраняет модель
     */
    public function save(): void
    {
        $this->insertGetModel($this->attributes);
    }
}

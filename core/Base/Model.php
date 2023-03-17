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
    private \PDO $connect;

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

    /**
     * Пользовательская query
     *
     * @param string $sql
     * @param array|null $params
     * @return false|\PDOStatement
     * @throws Exception
     */
    public function query($sql, array $params = null)
    {
        if (!$params) {
            return $this->connect->query($sql);
        }
        try {
            $connect = $this->connect->prepare($sql);
            $connect->execute($params);
        } catch (Exception $e) {
            throw new Exception("Не верный запрос {$sql}");
        }
        return $connect;
    }

    /**
     * Возвращает все данные из таблицы
     *
     * @return false|\PDOStatement
     */
    public function findAll(): bool|\PDOStatement
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->connect->query($sql)->fetchAll();
    }

    /**
     * Объявляет поля у метода
     *
     * @param string[] $PostData
     * @param string[] $ignores
     * @return void
     */
    public function load($PostData, $ignores): void
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
     *
     * @param array $data
     * @return array
     */
    public function validate($data): array
    {
        $validator = new Validator();

        $validator->setRules($this->rules);

        return $validator->validate($data);
    }


    /**
     * Поиск строки
     *
     * @param string $key
     * @param string $value
     * @return false|mixed
     * @throws Exception
     */
    public function find($key, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE " . $key . " = :value";
        $search = $this->query($sql, [':value' => $value])->fetch();

        return empty($search) ? false : $search;
    }

    /**
     * Вставка в Модель с явно указанными переменными
     *
     * @param array $dataUser
     * @return void
     */
    public function insertGetModel($dataUser): void
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
     *
     * @return void
     */
    public function save(): void
    {
        $this->insertGetModel($this->attributes);
    }
}

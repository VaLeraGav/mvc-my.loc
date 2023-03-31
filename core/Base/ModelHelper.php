<?php

namespace Core\Base;

use Core\Validator;

trait ModelHelper
{

    public function getConnect(): \PDO
    {
        return $this->connect;
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
        } catch (\Exception $e) {
            throw new \Exception("Не верный запрос {$sql}");
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

        if (!empty($this->rulesMessage)) {
            $validator->setRuleMessage($this->rulesMessage);
        }

        return $validator->validate($data);
    }

    public function hasErrors($data)
    {
        $validator = new Validator();

        $validator->setRules($this->rules);

        if (!empty($this->rulesMessage)) {
            $validator->setRuleMessage($this->rulesMessage);
        }
        $hasErrors = $validator->validate($data);

        if (empty($hasErrors)) {
            return false;
        }
        $this->errors = $hasErrors;
        return true;
    }

    /**
     * Поиск строки
     */
    public function find(string $key, string $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE " . $key . " = :value"; // не подготовленный запрос
        $search = $this->query($sql, [':value' => $value])->fetch();

        return empty($search) ? false : $search;
    }

    /**
     * Вставка в Модель с явно указанными переменными
     */
    public function insertGetModel(array $dataUser, $ignores = [])
    {
        $fields = array_filter($this->attributes, function ($name) use ($ignores) {
            return !in_array($name, $ignores);
        }, ARRAY_FILTER_USE_KEY);

        $keysFields = implode(', ', array_keys($fields));

        foreach ($fields as $k => $v) {
            $params[':' . $k] = $dataUser[$k];
        }

        $strParams = implode(', ', array_keys($params));

        $sql = "INSERT INTO `{$this->table}`({$keysFields}) VALUES ({$strParams})";

        $this->query($sql, $params);
    }

    /**
     * Обновление модели
     */
    public function updatetGetModel($id)
    {
        $str = '';
        foreach ($this->attributes as $k => $v) {
            $str .= "$k = '$v', ";
        }
        $str = rtrim($str, ', ');

        $sql = ("UPDATE `{$this->table}` SET {$str} WHERE `{$this->table}`.id = $id");

        $this->query($sql);
    }

    /**
     * Сохраняет модель, возвращает id последней вставленной строки
     */
    public function save()
    {
        $this->insertGetModel($this->attributes, ['password_confirmation', 'created_at', 'update_at']);
        return $this->connect->lastInsertId();
    }
}
<?php

namespace Core;

class Connection
{
    private static self $instance;
    private \PDO $connect;
    private array $options = [];

    private function __construct()
    {
        try {
            $this->setOption();
            $this->connect = $this->connection();
        } catch (\PDOException|\Exception$e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function setOption($option = [])
    {
        if (empty($option)) {
            $this->options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,// Устанавливает режим выборки по умолчанию
                \PDO::ATTR_STRINGIFY_FETCHES => false,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ];
        } else {
            $this->options = $option;
        }
    }

    public function connection(): \PDO
    {
        $conf_db = require CONF . '/database.php';

        if (!$conf_db['enable']) {
            throw new \Exception("DB выключенна");
        }
        $driver = $conf_db['driver'];
        $host = $conf_db['host'];
        $dbname = $conf_db['dbname'];
        $port = $conf_db['port'];
        $user = $conf_db['user'];
        $password = $conf_db['password'];

        return new \PDO(
            "$driver:host=$host;port=$port;dbname=$dbname",
            $user,
            $password, $this->options
        );
    }

    public static function otherConnect($dbName = null, $userName = null, $password = null, $options = null)
    {
        if (is_null($dbName)) {
            $dbName = 'sqlite:' . ROOT . '/identifier.sqlite';
        }
        return new \PDO($dbName, $userName, $password, $options);
    }

    public static function connectInstance(): Connection
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone()
    {
        \trigger_error('Class could not be cloned', \E_USER_ERROR);
    }

    private function __wakeup()
    {
        \trigger_error('Class could not be deserialized', \E_USER_ERROR);
    }

}
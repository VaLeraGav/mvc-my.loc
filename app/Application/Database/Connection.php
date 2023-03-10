<?php

namespace App\Application\Database;

class Connection
{
    private static \PDO $connect;

    private string $driver;
    private string $host;
    private string $dbname;
    private int $port;
    private string $user;
    private string $password;

    public function __construct()
    {
        $conf_db = require CONF . '/database.php';

        $this->driver = $conf_db['driver'];
        $this->host = $conf_db['host'];
        $this->dbname = $conf_db['dbname'];
        $this->port = $conf_db['port'];
        $this->user = $conf_db['user'];
        $this->password = $conf_db['password'];
    }

    public function connect(array $options = null)
    {
        try {

            $this->connect = new \PDO(
                "$this->driver:host=$this->host;port=$this->port;dbname=$this->dbname",
                $this->user,
                $this->password,
                $options
            );
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
        return $this->connect;
    }
}
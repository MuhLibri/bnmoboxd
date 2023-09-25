<?php

namespace app\db;

class Database
{
    public \PDO $pdo;

    public function __construct($config = []) {
        $host = $config['host'] ?? 'localhost';
        $port = $config['port'] ?? '3306';
        $db_name = $config['db_name'] ?? 'tubes';

        $dsn = 'mysql:host=' . $host . ';port=' .$port . ';dbname=' . $db_name;

        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new \PDO($dsn, $username, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function prepare($sql): \PDOStatement
    {
        return $this->pdo->prepare($sql);
    }

    private function log($message)
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }
}
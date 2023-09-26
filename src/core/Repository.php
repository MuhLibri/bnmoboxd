<?php

namespace app\core;

class Repository
{
    private \PDO $pdo;
    public string $forModel;
    public function __construct() {
        $this->pdo = Application::$db->pdo;
    }
    public function findOne($sql, $params)
    {
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $item) {
            $type = $this->getBindType($item);
            $stmt->bindValue(":$key", $item, $type);
        }
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getBindType($value) {
        switch (true) {
            case is_int($value):
                $type = \PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = \PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = \PDO::PARAM_NULL;
                break;
            default:
                $type = \PDO::PARAM_STR;
        }
        return $type;
    }
}
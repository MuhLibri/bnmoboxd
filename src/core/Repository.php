<?php

namespace app\core;

class Repository
{
    private \PDO $pdo;
    public function __construct() {
        $this->pdo = Application::$db->pdo;
    }
    protected function findOne($sql, $params)
    {
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $item) {
            $type = $this->getBindType($item);
            $stmt->bindValue(":$key", $item, $type);
        }
        $stmt->execute();
        return $stmt->fetch();
    }

    protected function findAll($sql, $params)
    {
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $item) {
            $type = $this->getBindType($item);
            $stmt->bindValue(":$key", $item, $type);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    protected function save($sql, $params) {
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $item) {
            $type = $this->getBindType($item);
            $stmt->bindValue(":$key", $item, $type);
        }
        $stmt->execute();
        return true;
    }

    protected function getBindType($value) {
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

    protected function buildPaginationQuery($query, $options) {
        $isLimited = false;
        $pageSize = 10;
        if (isset($options['take']) && is_numeric($options['take'])) {
            $pageSize = $options['take'];
            $query .= " LIMIT $pageSize";
            $isLimited = true;
        }

        if (isset($options['page']) && is_numeric($options['page'])) {
            if (!$isLimited) {
                $query .= " LIMIT $pageSize";
            }
            $page = (int)$options['page'];

            if ($page < 1) {
                $page = 1;
            }

            $offset = ($page - 1) * $pageSize;

            $query .= " OFFSET $offset";
        }

        return $query;
    }
}
<?php

namespace app\repositories;

use app\core\Application;
use app\core\Repository;
use app\models\User;

class UserRepository extends Repository
{
    public function __construct()
    {
        require_once Application::$BASE_DIR . '/src/modeLS/User.php';
        $user = new User();
        parent::__construct();
    }

    public function getUserByUsername(string $username) {
        $query = "SELECT * FROM users WHERE username = :username";
        $params = [
            'username' => 'userr',
        ];
        $res = $this->findOne($query, $params);
        var_dump($res);
        echo $res["username"];
    }
}
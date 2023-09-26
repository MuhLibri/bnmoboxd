<?php

namespace app\repositories;

use app\core\Application;
use app\core\Repository;

class UserRepository extends Repository
{
    public function __construct()
    {
        require_once Application::$BASE_DIR . '/src/modeLS/User.php';
        parent::__construct();
    }

    public function getUserByUsername(string $username) {
        $query = 'SELECT * FROM users WHERE username = :username';
        $params = [
            'username' => $username,
        ];
        $res = $this->findOne($query, $params);
        return $res;
    }

    public function getUserByEmail(string $email) {
        $query = 'SELECT * from users WHERE email = :email';
        $params = [
            'email' => $email,
        ];
        $res = $this->findOne($query, $params);
        return $res;
    }

    public function addUser(string $username, string $email, string $hashedPassword, string $firstName, string $lastName) {
        $params = [
            'username' => $username,
            'email' => $email,
            'hashedPassword' => $hashedPassword,
            'firstName' => $firstName,
        ];
        if ($lastName) {
            $query = 'INSERT INTO users (username, email, password_hash, first_name, last_name) VALUES (:username, :email, :hashedPassword, :firstName, :lastName)';
            $params['lastName'] = $lastName;
        } else {
            $query = 'INSERT INTO users (username, email, password_hash, first_name) VALUES (:username, :email, :hashedPassword, :firstName)';
        }

        $this->save($query, $params);
    }
}
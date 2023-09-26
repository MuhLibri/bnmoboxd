<?php

namespace app\services;

use app\core\Application;
use app\repositories\UserRepository;

class AuthService
{
    private UserRepository $userRepository;
    public function __construct()
    {
        require_once Application::$BASE_DIR . '/src/repositories/UserRepository.php';
        $this->userRepository = new UserRepository();
    }

    public function login($credentials): bool {
        $user = $this->userRepository->getUserByUsername($credentials['username']);
        if ($user) {
            $verify = password_verify($credentials['password'], $user['password_hash']);
            if ($verify) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                echo $_SESSION['username'];
                echo $_SESSION['role'];
                return true;
            }
        }
        return false;
    }
    /*
     * Service level validation: checks for unique email and unique username
     * Creates user if successful
     * */
    public function register($registerData): array {
        $errors = [];

        $user = $this->userRepository->getUserByEmail($registerData['email']);
        if ($user) {
            $errors['email'] = "Email is already taken";
        }

        $user = $this->userRepository->getUserByUsername($registerData['username']);
        if ($user) {
            $errors['username'] = "Username is already taken";
        }

        if (!empty($errors)) {
            return $errors;
        }

        $hashedPassword = $this->hashPassword($registerData['password']);
        $this->userRepository->addUser($registerData['username'], $registerData['email'], $hashedPassword, $registerData['first_name'], $registerData['last_name']);
        return [];
    }

    private function hashPassword ($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }

}
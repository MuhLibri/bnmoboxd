<?php

namespace app\services;

use app\core\Application;
use app\core\Service;
use app\exceptions\BadRequestException;
use app\repositories\UserRepository;

class AuthService extends Service
{
    private UserRepository $userRepository;
    public function __construct()
    {
        require_once Application::$BASE_DIR . '/src/repositories/UserRepository.php';
        $this->userRepository = new UserRepository();
    }

    public function login($credentials) {
        $errors = $this->validateRequired($credentials, ['username', 'password']);

        $this->handleValidationErrors($errors);

        $user = $this->userRepository->getUserByUsername($credentials['username']);
        if ($user) {
            $verify = password_verify($credentials['password'], $user['password_hash']);
            if ($verify) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                return;
            }
        }
        $this->handleValidationErrors($errors);
    }
    /*
     * Service level validation: checks for unique email and unique username
     * Creates user if successful
     * */
    public function register($registerData): array {
        $errors = $this->validateRequired($registerData, ['username', 'password', 'first_name', 'email']);
        $user = null;

        if (!isset($errors["email"])) {
            if (!$this->validateEmail($registerData['email'])){
                $errors['email'] = 'Email is invalid';
            } else {
                $user = $this->userRepository->getUserByEmail($registerData['email']);
            }
        }

        if ($user) {
            $errors['email'] = "Email is already taken";
        }

        $user = $this->userRepository->getUserByUsername($registerData['username']);

        if ($user) {
            $errors['username'] = "Username is already taken";
        }

        $this->handleValidationErrors($errors);

        $hashedPassword = $this->hashPassword($registerData['password']);
        $this->userRepository->addUser($registerData['username'], $registerData['email'], $hashedPassword, $registerData['first_name'], $registerData['last_name']);
        return [];
    }

    private function hashPassword ($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    private function validateEmail(string $email): bool {
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        return preg_match($pattern, $email);
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }

}
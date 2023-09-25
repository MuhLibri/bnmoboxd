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

    public function login() {
        $this->userRepository->getUserByUsername("user1");
    }

}
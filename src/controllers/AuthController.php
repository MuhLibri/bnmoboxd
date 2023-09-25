<?php

namespace app\controllers;

use app\core\Controller;
use app\services\AuthService;
use app\core\Application;

class AuthController extends Controller
{
    private AuthService $authService;
    public function __construct() {
        require_once Application::$BASE_DIR . '/src/services/AuthService.php';
        $this->authService = new AuthService();
    }

    public function loginPage() {
        $this->render('login');
    }

    public function login() {
        $this->authService->login();
    }
}
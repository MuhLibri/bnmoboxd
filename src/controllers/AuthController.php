<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\exceptions\BadRequestException;
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
        if (!empty($_SESSION['username'])) {
            Application::$app->response->redirect('/');
        }
        $this->render('login');
    }

    public function registerPage() {
        if (!empty($_SESSION['username'])) {
            Application::$app->response->redirect('/');
        }
        $this->render('register');
    }


    public function login(Request $request) {
        $credentials = $request->getBody();
        $this->authService->login($credentials);
        echo Application::$app->response->jsonEncode(200, ['errors' => []]);
    }

    public function register(Request $request) {
        $registerData = $request->getBody();
        $this->authService->register($registerData);
        echo Application::$app->response->jsonEncode(200, []);
    }

    public function logout() {
        $this->authService->logout();
        Application::$app->response->redirect('/login');
        exit;
    }
}
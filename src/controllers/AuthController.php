<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\exceptions\BadRequestException;
use app\services\UserService;
use app\core\Application;

class AuthController extends Controller
{
    private UserService $userService;
    public function __construct() {
        require_once Application::$BASE_DIR . '/src/services/UserService.php';
        $this->userService = new UserService();
        $this->view = "auth";
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


    /**
     * @throws BadRequestException
     */
    public function login(Request $request) {
        $credentials = $request->getBody();
        $this->userService->login($credentials);
        echo Application::$app->response->jsonEncode(200, ['errors' => []]);
    }

    public function register(Request $request) {
        $registerData = $request->getBody();
        $this->userService->register($registerData);
        echo Application::$app->response->jsonEncode(200, []);
    }

    public function logout() {
        $this->userService->logout();
        Application::$app->response->redirect('/login');
        exit;
    }
}
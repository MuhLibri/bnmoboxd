<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
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


    /*
     * Controller layer validation for required values and value types
     * return login validation errors, empty if login is successful
    */
    public function login(Request $request) {
        $credentials = $request->getBody();
        $errors = $this->validateRequired($credentials, ['username', 'password']);

        if (!empty($errors)) {
            echo Application::$app->response->jsonEncode(400, ['errors' => $errors]);
            return;
        }

        $verify = $this->authService->login($credentials);
        if (!$verify) {
            $errors['auth'] = 'Invalid username or password';
            echo Application::$app->response->jsonEncode(401, ['errors' => $errors]);
            return;
        }

        echo Application::$app->response->jsonEncode(200, ['errors' => []]);
    }

    public function register(Request $request) {
        $registerData = $request->getBody();
        $errors = $this->validateRequired($registerData, ['username', 'password', 'first_name', 'email']);

        if (!isset($errors["email"])) {
            if (!$this->validateEmail($registerData['email'])){
                $errors['email'] = 'Email is invalid';
            }
        }

        if(!empty($errors)) {
            echo Application::$app->response->jsonEncode(400, ['errors' => $errors]);
            return;
        }

        $errors = $this->authService->register($registerData);

        if(!empty($errors)) {
            echo Application::$app->response->jsonEncode(400, ['errors' => $errors]);
            return;
        }

        echo Application::$app->response->jsonEncode(200, []);
    }

    public function validateEmail(string $email): bool {
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        return preg_match($pattern, $email);
    }

    public function logout() {
        $this->authService->logout();
        Application::$app->response->redirect('/login');
        exit;
    }
}
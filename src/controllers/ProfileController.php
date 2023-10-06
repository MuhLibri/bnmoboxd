<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\exceptions\BadRequestException;
use app\exceptions\NotFoundException;
use app\middlewares\AuthMiddleware;
use app\services\UserService;

class ProfileController extends Controller
{
    private UserService  $userService;

    public function __construct()
    {
        require_once Application::$BASE_DIR . '/src/services/UserService.php';
        require_once Application::$BASE_DIR . '/src/middlewares/AuthMiddleware.php';
        $this->userService = new UserService();
        $this->view = 'profile';
        $this->middlewares = [
          'index' => AuthMiddleware::class
        ];
    }

    public function index() {
        $username = $_SESSION['username'];
        $user = $this->userService->getUserProfile($username);
        $this->render('index', ['profile' => $user]);
    }

    /**
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function edit(Request $request) {
        $data = $request->getBody();
        $data['user_id'] = $_SESSION['user_id'];
        $this->userService->updateUser($data);
    }

    /**
     * @throws NotFoundException
     */
    public function delete() {
        $username = $_SESSION['username'];
        $this->userService->deleteUser($username);
    }
}
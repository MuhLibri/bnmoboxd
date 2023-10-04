<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\middlewares\AuthMiddleware;

class ReviewsController extends Controller
{
    public function __construct() {
        require_once Application::$BASE_DIR . '/src/middlewares/AuthMiddleware.php';
        $this->view = 'reviews';
        $this->middlewares = [
            "index" => AuthMiddleware::class
        ];
    }

    public function index() {
        $this->render('index', []);
    }

    public function edit() {
        $this->render('edit', []);
    }
}
<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\middlewares\AuthMiddleware;

class ReviewsController extends Controller
{
    public function __construct() {
        require_once Application::$BASE_DIR . '/src/middlewares/AuthMiddleware.php';
        $this->middlewares = [
            "index" => AuthMiddleware::class
        ];
    }

    public function index() {
        echo "LOGGED IN";
    }
}
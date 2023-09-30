<?php

namespace app\controllers;

class WatchListController extends Controller
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
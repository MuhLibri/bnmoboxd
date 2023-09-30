<?php

namespace app\middlewares;

use app\core\Application;
use app\core\Middleware;
use app\exceptions\ForbiddenException;

class AuthMiddleware extends Middleware
{
    /**
     * @throws ForbiddenException
     */
    public function execute($isView = false)
    {
        if (!isset($_SESSION['user_id'])) {
            echo Application::$app->response->redirect('/login');
        }
    }
}
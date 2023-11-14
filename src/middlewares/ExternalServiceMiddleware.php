<?php

namespace app\middlewares;

use app\core\Application;
use app\core\Middleware;
use app\exceptions\UnauthorizedException;

class ExternalServiceMiddleware extends Middleware {
    /**
     * @throws UnauthorizedException
     */
    public function execute($isView = false){
        if(!isset($_SERVER['HTTP_X_API_KEY'])){
            throw new UnauthorizedException($isView);
        }
        if ($_SERVER['HTTP_X_API_KEY'] != Application::$config['PHP_API_KEY']) {
            throw new UnauthorizedException($isView);
        }
    }
}
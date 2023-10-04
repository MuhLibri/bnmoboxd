<?php

namespace app\middlewares;

use app\core\Middleware;
use app\exceptions\NotFoundException;
use app\exceptions\ForbiddenException;

class AdminMiddleware extends Middleware {
    public function execute($isView = false){
        if(!isset($_SESSION['role'])){
            throw new NotFoundException($isView);
        }elseif($_SESSION['role'] != 'admin'){
            throw new ForbiddenException($isView);
        }
    }
}
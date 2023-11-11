<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\exceptions\BadRequestException;
use app\exceptions\ForbiddenException;
use app\exceptions\NotFoundException;
use app\middlewares\AuthMiddleware;
use app\middlewares\ExternalServiceMiddleware;
use app\services\CuratorsService;
use app\services\FilmReviewService;
use app\services\SubscriptionService;


class SubscriptionController extends Controller {
    private SubscriptionService $subscriptionService;

    public function __construct() {
        require_once Application::$BASE_DIR . '/src/services/SubscriptionService.php';
        require_once Application::$BASE_DIR . '/src/middlewares/ExternalServiceMiddleware.php';
        $this->subscriptionService = new SubscriptionService();
        $this->middlewares = [
            "update" => ExternalServiceMiddleware::class
        ];
    }

    /**
     * @throws BadRequestException
     */
    public function update(Request $request) {
        $subscriptionData = $request->getBody();
        $this->subscriptionService->updateSubscription($subscriptionData);
    }

}
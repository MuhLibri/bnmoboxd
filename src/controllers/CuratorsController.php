<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\exceptions\BadRequestException;
use app\exceptions\ForbiddenException;
use app\exceptions\NotFoundException;
use app\middlewares\AuthMiddleware;
use app\services\CuratorsService;
use app\services\FilmReviewService;


class CuratorsController extends Controller {
    private CuratorsService $curatorsService;

    public function __construct() {
        require_once Application::$BASE_DIR . '/src/services/CuratorsService.php';
        require_once Application::$BASE_DIR . '/src/middlewares/AuthMiddleware.php';

        $this->curatorsService = new CuratorsService();
        $this->view = 'curators';
        $this->middlewares = [
            "index" => AuthMiddleware::class,
            "search" => AuthMiddleware::class,
            "subscribe" => AuthMiddleware::class,
            "show" => AuthMiddleware::class
        ];
    }

    public function index() {
        $curators = $this->curatorsService->getCurators(['page' => 1, 'take' => 5]);
//        $curators = ['curators' => [['id' => 1, 'count' => $this->curatorsService->getSubscriber(1), 'status' => $this->curatorsService->getSubscriptionStatus(1, $userId)], ['id' => 2, 'count' => $this->curatorsService->getSubscriber(2), 'status' => $this->curatorsService->getSubscriptionStatus(2, $userId)], ['id' => 3, 'count' => $this->curatorsService->getSubscriber(3), 'status' => $this->curatorsService->getSubscriptionStatus(3, $userId)], ['id' => 4, 'count' => $this->curatorsService->getSubscriber(4), 'status' => $this->curatorsService->getSubscriptionStatus(4, $userId)]]];
        $this->render('index', array_merge($curators, [ 'currentPage' => 1, 'pageSize' => 5]));
//        $this->render('index', array_merge($curators, ['currentPage' => 1, 'pageSize' => 5]));
    }

    public function search(Request $request) {
        $options = $request->getQuery();
        $curators = $this->curatorsService->getCurators($options);
        return $this->renderComponent('curator-list', array_merge($curators, ['currentPage' => $options['page'], 'pageSize' => $options['take']]));
    }

    public function subscribe(Request $request) {
        $curatorUsername = $request->getParams()[0];
        $subscriberUsername = $_SESSION['username'];
        $this->curatorsService->createSubscription($curatorUsername, $subscriberUsername);
    }


    public function show(Request $request) {
        $username = ($request->getParams())[0];
        $data = $this->curatorsService->getCuratorDetail($username);
        $this->render('show', array_merge($data, ['currentPage' => 1, 'pageSize' => 5]));
    }
} 
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
    private FilmReviewService $filmReviewService;
    private CuratorsService $curatorsService; 

    public function __construct() {
        require_once Application::$BASE_DIR . '/src/services/FilmReviewService.php';
        require_once Application::$BASE_DIR . '/src/services/CuratorsService.php';
        require_once Application::$BASE_DIR . '/src/middlewares/AuthMiddleware.php';

        $this->filmReviewService = new FilmReviewService();
        $this->curatorsService = new CuratorsService();
        $this->view = 'curators';
        $this->middlewares = [
            "index" => AuthMiddleware::class,
            "createPage" => AuthMiddleware::class,
            "editPage" => AuthMiddleware::class,
            "create" => AuthMiddleware::class,
            "edit" => AuthMiddleware::class,
            "delete" => AuthMiddleware::class
        ];
    }

    public function index() {
        $userId = $_SESSION['user_id'];
        $curators = ['curators' => [['id' => 1, 'count' => $this->curatorsService->getSubscriber(1), 'status' => $this->curatorsService->getSubscriptionStatus(1, $userId)], ['id' => 2, 'count' => $this->curatorsService->getSubscriber(2), 'status' => $this->curatorsService->getSubscriptionStatus(2, $userId)], ['id' => 3, 'count' => $this->curatorsService->getSubscriber(3), 'status' => $this->curatorsService->getSubscriptionStatus(3, $userId)], ['id' => 4, 'count' => $this->curatorsService->getSubscriber(4), 'status' => $this->curatorsService->getSubscriptionStatus(4, $userId)]]];
        $this->render('index', array_merge($curators, ['currentPage' => 1, 'pageSize' => 5]));
    }

    public function show(Request $request) {
        $id = ($request->getParams())[0];
        $userId = $_SESSION['user_id'];
        $reviewsData = $this->filmReviewService->getUserReviews($userId, ['take' => 5]);
        $this->render('show', array_merge($reviewsData, ['subscriber' => $this->curatorsService->getSubscriber($id), 'status' => $this->curatorsService->getSubscriptionStatus($id, $userId), 'currentPage' => 1, 'pageSize' => 5]));
    }
} 
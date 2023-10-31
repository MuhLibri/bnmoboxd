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
        $this->render('index', ['id' => 1, 'currentPage' => 1, 'pageSize' => 5]);
    }

    public function show(Request $request) {
        // $reviewId = $this->getReviewIdFromParam($request->getParams());
        // $userId = $_SESSION['user_id'];
        // $review = $this->filmReviewService->getReview($reviewId, $userId);
        // $review['id'] = $reviewId;
        // $this->render('edit', ['review' => $review]);

        $data['id'] = ($request->getParams())[0];
        $userId = $_SESSION['user_id'];
        $reviewsData = $this->filmReviewService->getUserReviews($userId, ['take' => 5]);
        $this->render('show', array_merge($reviewsData, ['currentPage' => 1, 'pageSize' => 5, 'id' => $data['id']]));
    }
} 
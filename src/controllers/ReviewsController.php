<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\exceptions\BadRequestException;
use app\exceptions\ForbiddenException;
use app\exceptions\NotFoundException;
use app\middlewares\AuthMiddleware;
use app\services\FilmReviewService;

class ReviewsController extends Controller{
    private FilmReviewService $filmReviewService;

    public function __construct() {
        require_once Application::$BASE_DIR . '/src/services/FilmReviewService.php';
        require_once Application::$BASE_DIR . '/src/middlewares/AuthMiddleware.php';

        $this->filmReviewService = new FilmReviewService();
        $this->view = 'reviews';
        $this->filmReviewService = new FilmReviewService();
        $this->middlewares = [
            "index" => AuthMiddleware::class
        ];
    }

    public function index() {
        $userId = $_SESSION['user_id'];
        $reviewsData = $this->filmReviewService->getUserReviews($userId, []);
        $this->render('index', $reviewsData);
    }

    /**
     * @throws NotFoundException
     * @throws ForbiddenException
     */
    public function show(Request $request) {
        $reviewId = $request->getParams()[0];
        $userId = $_SESSION['user_id'];
        $review = $this->filmReviewService->getReview($reviewId, $userId);
    }

    /**
     * @throws BadRequestException
     */
    public function create(Request $request) {
        $reviewData = $request->getBody();
        $userId = $_SESSION['user_id'];
        $this->filmReviewService->create($reviewData, $userId);
    }

    /**
     * @throws ForbiddenException
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function edit(Request $request) {
        $reviewData = $request->getBody();
        $reviewId = $request->getParams()[0];
        $userId = $_SESSION['user_id'];
        $this->filmReviewService->edit($reviewData, $userId, $reviewId);
    }

    /**
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function delete(Request $request) {
        $reviewId = $request->getParams()[0];
        $userId = $_SESSION['user_id'];
        $this->filmReviewService->delete($reviewId, $userId);
    }
}
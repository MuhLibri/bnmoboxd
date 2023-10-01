<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\services\FilmReviewService;
use app\services\FilmService;

class DashboardController extends Controller
{
    private FilmReviewService $filmReviewService;
    private FilmService $filmService;
    public function __construct() {
        require_once Application::$BASE_DIR . '/src/services/FilmReviewService.php';
        require_once Application::$BASE_DIR . '/src/services/FilmService.php';
        $this->filmReviewService = new FilmReviewService();
        $this->filmService = new FilmService();
    }
    public function index() {
        $filmReviews = $this->filmReviewService->getFilmReviews();
        $filmsData = $this->filmService->getFilms(['take' => 6]);
        $this->render('index', ["filmReviews" => $filmReviews, "films" => $filmsData['films']]);
    }
}
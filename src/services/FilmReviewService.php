<?php

namespace app\services;

use app\core\Application;
use app\repositories\FilmRepository;
use app\repositories\FilmReviewRepository;

class FilmReviewService
{
    private FilmReviewRepository $filmReviewRepository;
    public function __construct()
    {
        require_once Application::$BASE_DIR . '/src/repositories/FilmReviewRepository.php';
        $this->filmReviewRepository = new FilmReviewRepository();
    }

    public function getFilmReviews() {
        return $this->filmReviewRepository->getAll();
    }
}
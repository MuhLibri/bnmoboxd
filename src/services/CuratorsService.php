<?php

namespace app\services;

use app\core\Application;
use app\core\Service;
use app\exceptions\BadRequestException;
use app\exceptions\ForbiddenException;
use app\exceptions\NotFoundException;
// use app\repositories\FilmRepository;
// use app\repositories\FilmReviewRepository;

class CuratorsService extends Service {
    public function __construct() {
        // require_once Application::$BASE_DIR . '/src/repositories/FilmReviewRepository.php';
        // $this->filmReviewRepository = new FilmReviewRepository();
    }

}
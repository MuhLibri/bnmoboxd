<?php
namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Controller;
use app\exceptions\BadRequestException;
use app\exceptions\NotFoundException;
use app\middlewares\AdminMiddleware;
use app\services\FilmService;
use app\services\FilmReviewService;

class ApiController extends Controller
{
    private FilmService $filmService;


    public function __construct(){
        require_once Application::$BASE_DIR . '/src/services/FilmService.php';

        $this->view = 'films';
        $this->filmService = new FilmService();
    }


    public function search(Request $request) {
        $options = $request->getQuery();
        $filmsData = $this->filmService->getFilmTitles($options);
        return json_encode($filmsData);
    }
}
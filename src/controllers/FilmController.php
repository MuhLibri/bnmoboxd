<?php
namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Controller;
use app\exceptions\NotFoundException;
use app\services\FilmService;
use app\services\FilmReviewService;

class FilmController extends Controller
{
    private FilmService $filmService;
    private FilmReviewService $filmReviewService;

    public function __construct(){
        require_once Application::$BASE_DIR . '/src/services/FilmService.php';
        require_once Application::$BASE_DIR . '/src/services/FilmReviewService.php';

        $this->view = 'films';
        $this->filmService = new FilmService();
        $this->filmReviewService = new FilmReviewService();
    }

    public function index(Request $request) {
        $filmsData = $this->filmService->getFilms(['take' => 21]);
        $this->render('index', array_merge($filmsData, ['currentPage' => 1, 'pageSize' => 21]));
    }

    public function show(Request $request) {
        $id = $request->getParams()[0];
        $film = $this->filmService->getFilm($id);
        
        if($film){
            $reviews = $this->filmReviewService->getReviewsWithFilmId($id);
            $this->render('show', ['film' => $film, 'reviews' => $reviews]);
        }else{
            throw new NotFoundException(true);
        }
    }

    public function search(Request $request) {
        $options = $request->getQuery();
        $filmsData = $this->filmService->getFilms($options);
        $currentPage = $options['page'] ?? 1;
        return $this->renderComponent('film-posters', array_merge($filmsData, ['currentPage' => $currentPage, 'pageSize' => 21]));
    }
}
<?php
namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Controller;
use app\services\FilmService;
class FilmController extends Controller
{
    private FilmService $filmService;
    public function __construct(){
        require_once Application::$BASE_DIR . '/src/services/FilmService.php';
        $this->view = 'films';
        $this->filmService = new FilmService();
    }

    public function index(Request $request) {
        $filmsData = $this->filmService->getFilms();
        $this->render('index', array_merge($filmsData, ['currentPage' => 1]));
    }

    public function show(Request $request) {
        $id = $request->getParams()[0];
        $film = $this->filmService->getFilm($id);

        // Test echo
        if($film){
            echo $film['id'] . ' ' . $film['title'];
        }else{
            echo 'No such film';
        }
    }

    public function search(Request $request) {
        $options = $request->getQuery();
        $filmsData = $this->filmService->getFilms($options);
        $currentPage = $options['page'] ?? 1;
        return $this->renderComponent('film-posters', array_merge($filmsData, ['currentPage' => $currentPage]));
    }
}
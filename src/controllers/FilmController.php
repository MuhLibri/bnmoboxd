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
        $this->filmService = new FilmService();
    }

    public function index(Request $request) {
        $films = $this->filmService->getFilms(['take' => 10]);
        $this->render('films', ["films" => $films]);
    }
    public function show(Request $request) {
        $id = $request->getParams()[0];
        return $this->filmService->getFilm($id);
    }

    public function search(Request $request) {
        $options = $request->getQuery();
        $films = $this->filmService->getFilms($options);
        return $this->renderContent('components/film-posters', ["films" => $films]);
    }
}
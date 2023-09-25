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
        $id = $request->getParams()[0];
        return $this->render('test');
    }
    public function show(Request $request) {
        $id = $request->getParams()[0];
        return $this->filmService->getFilm($id);
    }
}
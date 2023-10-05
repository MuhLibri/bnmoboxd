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

class FilmController extends Controller
{
    private FilmService $filmService;
    private FilmReviewService $filmReviewService;

    public function __construct(){
        require_once Application::$BASE_DIR . '/src/services/FilmService.php';
        require_once Application::$BASE_DIR . '/src/services/FilmReviewService.php';
        require_once Application::$BASE_DIR . '/src/middlewares/AdminMiddleware.php';

        $this->view = 'films';
        $this->filmService = new FilmService();
        $this->filmReviewService = new FilmReviewService();
        $this->middlewares = [
            'createPage' => AdminMiddleware::class,
            'editPage' => AdminMiddleware::class,
            'create' => AdminMiddleware::class,
            'edit' => AdminMiddleware::class,
            'delete' => AdminMiddleware::class
        ];
    }
    
    public function createPage(Request $request){
        $this->render('update', []);
    }

    /**
     * @throws NotFoundException
     */
    public function editPage(Request $request){
        $id = $this->getFilmIdFromParam($request->getParams());
        $film = $this->filmService->getFilm($id);

        if($film){
            $this->render('update', ['film' => $film]);
        }else{
            throw new NotFoundException(true);
        }
    }

    /**
     * @throws BadRequestException
     */
    public function create(Request $request){
        $data = $request->getBody();
        $id = $this->filmService->createFilm($data);
        echo Application::$app->response->jsonEncode(200, ['id' => $id]);
    }

    /**
     * @throws NotFoundException
     * @throws BadRequestException
     */
    public function edit(Request $request){
        $data = $request->getBody();
        $data['id'] = $request->getParams()[0];
        $this->filmService->updateFilm($data);
    }

    /**
     * @throws NotFoundException
     */
    public function delete(Request $request){
        $id = $this->getFilmIdFromParam($request->getParams());
        $this->filmService->deleteFilm($id);
    }
    
    public function index(Request $request) {
        $filmsData = $this->filmService->getFilms(['take' => 21]);
        $this->render('index', array_merge($filmsData, ['currentPage' => 1, 'pageSize' => 21]));
    }

    /**
     * @throws NotFoundException
     */
    public function show(Request $request) {
        $id = $this->getFilmIdFromParam($request->getParams());
        $film = $this->filmService->getFilm($id);
        
        if($film){
            $reviews = $this->filmReviewService->getReviewsWithFilmId($id);
            $this->render('show', ['film' => $film, 'reviews' => $reviews, 'admin' => isset($_SESSION['role']) && $_SESSION['role'] == 'admin']);
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

    /**
     * @throws NotFoundException
     */
    private function getFilmIdFromParam($params) {
        $filmId = $params[0];
        if(!is_numeric($filmId) || !preg_match('/^[0-9]+$/', $filmId)){
            throw new NotFoundException(true);
        }
        return $filmId;
    }
}
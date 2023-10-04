<?php

namespace app\services;

use app\core\Application;
use app\core\Service;
use app\exceptions\ForbiddenException;
use app\exceptions\NotFoundException;
use app\repositories\FilmRepository;

class FilmService extends Service {
    private FilmRepository $filmRepository;

    public function __construct(){
        require_once Application::$BASE_DIR . '/src/repositories/FilmRepository.php';
        $this->filmRepository = new FilmRepository();
    }

    public function getFilms($options = []){
        return $this->filmRepository->getAll($options);
    }

    public function getFilm(string $id){
        return $this->filmRepository->getById($id);
    }

    public function updateFilm(array $data){
        $this->validateUpdateFilmFields($data);

        $posterImagePath = null;
        $trailerVideoPath = null;

        if(isset($_FILES['film-poster']) && $_FILES['film-poster']['name'] !== ''){
            $posterImagePath = saveFile($_FILES['film-poster'], Application::$BASE_DIR . '/public/assets/films/');
        }
        if(isset($_FILES['film-trailer']) && $_FILES['film-trailer']['name'] !== ''){
            $trailerVideoPath = saveFile($_FILES['film-trailer'], Application::$BASE_DIR . '/public/assets/films/trailers/');
        }

        $this->filmRepository->updateFilm(
            $data['id'],
            $data['title'],
            $data['release-year'],
            $data['director'],
            $data['genre'],
            $data['description'],
            $posterImagePath,
            $trailerVideoPath
        );
    }

    private function validateUpdateFilmFields(array $data){
        $errors = $this->validateRequired($data, ['title', 'release-year', 'director']);
        $id = $data['id'];
        if(!is_numeric($id) || !preg_match('/^[0-9]+$/', $id)){
            throw new ForbiddenException(true);
        }

        $film = $this->filmRepository->getById($id);
        if(!$film){
            throw new NotFoundException(true);
        }

        if(!isset($errors['release-year'])){
            $errors = array_merge($errors, $this->validateReleaseYear($data['release-year']));
        }

        $this->handleValidationErrors($errors);
    }

    private function validateReleaseYear(string $year){
        $errors = [];

        if(!is_numeric($year) || !preg_match('/^[1-9][0-9]*$/', $year)){
            $errors['release-year'] = 'Release year must be a valid year';
        }elseif($year < 1900){
            $errors['release-year'] = 'Release year must be 1900 or later';
        }

        return $errors;
    }
}
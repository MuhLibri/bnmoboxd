<?php

namespace app\services;

use app\core\Application;
use app\core\Service;
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

    public function createFilm(array $data){
        $this->validateCreateFilmFields($data);

        $posterImagePath = null;
        $trailerVideoPath = null;

        if(isset($_FILES['film_poster']) && $_FILES['film_poster']['name'] !== ''){
            $posterImagePath = saveFile($_FILES['film_poster'], Application::$BASE_DIR . '/public/assets/films/');
        }
        if(isset($_FILES['film_trailer']) && $_FILES['film_trailer']['name'] !== ''){
            $trailerVideoPath = saveFile($_FILES['film_trailer'], Application::$BASE_DIR . '/public/assets/films/trailers/');
        }

        $id = $this->filmRepository->addFilm(
            $data['title'],
            $data['release_year'],
            $data['director'],
            $data['genre'],
            $data['description'],
            $posterImagePath,
            $trailerVideoPath
        );

        return $id;
    }

    public function updateFilm(array $data){
        $this->validateUpdateFilmFields($data);

        $posterImagePath = null;
        $trailerVideoPath = null;

        if(isset($_FILES['film_poster']) && $_FILES['film_poster']['name'] !== ''){
            $posterImagePath = saveFile($_FILES['film_poster'], Application::$BASE_DIR . '/public/assets/films/');
        }
        if(isset($_FILES['film_trailer']) && $_FILES['film_trailer']['name'] !== ''){
            $trailerVideoPath = saveFile($_FILES['film_trailer'], Application::$BASE_DIR . '/public/assets/films/trailers/');
        }

        $this->filmRepository->updateFilm(
            $data['id'],
            $data['title'],
            $data['release_year'],
            $data['director'],
            $data['genre'],
            $data['description'],
            $posterImagePath,
            $trailerVideoPath
        );
    }

    private function validateCreateFilmFields(array $data){
        $errors = $this->validateRequired($data, ['title', 'release_year', 'director']);

        if(!isset($errors['release_year'])){
            $errors = array_merge($errors, $this->validateReleaseYear($data['release_year']));
        }

        if(!isset($errors['film_poster'])){
            $errors = array_merge($errors, $this->validateFilmPoster());
        }

        $this->handleValidationErrors($errors);
    }

    private function validateUpdateFilmFields(array $data){
        $errors = $this->validateRequired($data, ['title', 'release_year', 'director']);
        $id = $data['id'];
        if(!is_numeric($id) || !preg_match('/^[0-9]+$/', $id)){
            throw new NotFoundException(true);
        }

        $film = $this->filmRepository->getById($id);
        if(!$film){
            throw new NotFoundException(true);
        }

        if(!isset($errors['release_year'])){
            $errors = array_merge($errors, $this->validateReleaseYear($data['release_year']));
        }

        $this->handleValidationErrors($errors);
    }

    private function validateReleaseYear(string $year){
        $errors = [];

        if(!is_numeric($year) || !preg_match('/^[1-9][0-9]*$/', $year)){
            $errors['release_year'] = 'Release year must be a valid year';
        }elseif($year < 1900){
            $errors['release_year'] = 'Release year must be 1900 or later';
        }

        return $errors;
    }

    private function validateFilmPoster(){
        $errors = [];

        if(!isset($_FILES['film_poster']) || $_FILES['film_poster']['name'] == ''){
            $errors['film_poster'] = 'A film poster must be provided';
        }

        return $errors;
    }
}
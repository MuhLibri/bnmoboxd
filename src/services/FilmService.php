<?php

namespace app\services;

use app\core\Application;
use app\repositories\FilmRepository;

class FilmService
{
    private FilmRepository $filmRepository;
    public function __construct()
    {
        require_once Application::$BASE_DIR . '/src/repositories/FilmRepository.php';
        $this->filmRepository = new FilmRepository();
    }

    public function getFilms($options = []) {
        return $this->filmRepository->getAll($options);
    }

    public function getFilm(string $id){
        return $this->filmRepository->getById($id);
    }
}
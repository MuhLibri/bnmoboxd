<?php

namespace app\services;

class FilmService
{
    public function __construct()
    {
    }

    public function getFilm(string $id){
        return "Got film ". $id;
    }
}
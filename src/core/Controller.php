<?php

namespace app\core;

const VIEW_DIR = __DIR__ . '/../views/';

class Controller
{
    public function render($view, $data = []) {
        require_once VIEW_DIR . $view . '.php';
    }
}
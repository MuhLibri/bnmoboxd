<?php

namespace app\core;

const VIEW_DIR = __DIR__ . '/../views';

class Controller
{
    protected array $middlewares = [];

    public function render($view, $data = []) {
        $content = $this->renderContent($view, $data);
        ob_start();
        include_once VIEW_DIR . "/layouts/layout.php";
        $layout = ob_get_clean();
        $layout = str_replace('{{page}}', $view, $layout);
        $layout = str_replace('{{pageTitle}}', ucwords($view), $layout);
        $layout = str_replace('{{content}}', $content, $layout);
        echo $layout;
    }

    public function renderContent($content, $data){
        ob_start();
        include_once VIEW_DIR . "/$content.php";
        return ob_get_clean();
    }

    public function renderComponent($component, $data) {
        include_once VIEW_DIR . "/components/$component.php";
        return call_user_func($component, $data);
    }

//    protected function validateRequired($data, $fields) {
//        $errors = [];
//        foreach ($fields as $field) {
//            if (!isset($data[$field]) || $data[$field] === '') {
//                $errors[$field] = ucfirst(str_replace("_", " ", $field)) . ' is required';
//            }
//        }
//
//        if (!empty($errors)) {
//            throw new BadRequestException(false, ['errors' => $errors]);
//        }
//    }

    public function getMiddlewares() {
        return $this->middlewares;
    }
}
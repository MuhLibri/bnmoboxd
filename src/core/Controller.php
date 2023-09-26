<?php

namespace app\core;

const VIEW_DIR = __DIR__ . '/../views';

class Controller
{
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

    protected function validateRequired($data, $fields): array {
        $errors = [];
        foreach ($fields as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                $errors[$field] = ucfirst(str_replace("_", " ", $field)) . ' is required';
            }
        }
        return $errors;
    }
}
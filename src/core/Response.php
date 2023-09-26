<?php

namespace app\core;

class Response
{
    public function setStatusCode(int $statusCode) {
        http_response_code($statusCode);
    }

    public function jsonEncode($statusCode, $data) {
        $this->setStatusCode($statusCode);
        header('Content-Type: application/json');
        return json_encode($data);
    }

    public function redirect(string $url) {
        header("Location: $url");
    }
}
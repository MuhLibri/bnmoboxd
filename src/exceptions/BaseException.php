<?php

namespace app\exceptions;

use app\core\Application;

class BaseException extends \Exception
{
    public bool $isView;
    public array $data;
    public function __construct($code, $message, $isView = false, $data = [])
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = array_merge($data, ["message" => $this->message]);
        $this->isView = $isView;
    }

    public function handle(){
        $errorCode = $this->code;
        $data = $this->data;
        if ($this->isView) {
            include_once Application::$BASE_DIR . "/src/views/layouts/_error.php";
        } else {
            echo Application::$app->response->jsonEncode($this->code, $this->data);
        }
    }
}
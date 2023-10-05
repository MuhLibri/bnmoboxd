<?php

namespace app\core;

class Request
{
    private string $path;
    private string $method;
    private array $params;

    public function __construct(){
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);

        $path = $_SERVER['REQUEST_URI'] ?? '/';
        if ($path !== '/'){
            $path = rtrim($path, '/');
        }
        $pos = strpos($path, '?');
        if ($pos!== false) {
            $path = substr($path, 0, $pos);
        }
        $this->path = $path;
    }
    public function getPath(): string {
        return $this->path;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getParams(): array{
        return $this->params;
    }

    public function setParams(array $params){
        $this->params = $params;
    }

    public function getQuery(): array {
        $data = [];
        if($this->method==="get"){
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }

    public function getBody(): array{
        $data = [];
        if($this->method==="post"){
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }elseif($this->method === "put"){
            $putStream = fopen('php://input', 'r');
            $putData = '';
            while($putChunk = fread($putStream, 1024)){
                $putData .= $putChunk;
            }
            fclose($putStream);

            $putJson = json_decode($putData);
            foreach($putJson as $key => $value){
                $data[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }
    // function parseUrl
}
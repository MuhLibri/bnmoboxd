<?php

namespace app\core;

use app\db\Database;

class Application {
    public static Application $app;
    public static string $BASE_DIR;

    public static Database $db;
    public Router $router;
    public Request $request;
    public Response $response;

    public function __construct(string $baseDir, $config) {
        self::$app = $this;
        self::$BASE_DIR = $baseDir;
        self::$db = new Database($config['db']);

        $this->request = new Request();
        $this->response = new Response();

        $this->router = new Router($this->request, $this->response);
    }

    public function run() {
        echo $this->router->resolve();
    }
}
<?php

namespace app\core;

use app\db\Database;
use app\exceptions\BaseException;
use app\exceptions\NotFoundException;

class Application {
    public static Application $app;
    public static string $BASE_DIR;
    public static $config;
    public static Database $db;
    public Router $router;
    public Request $request;
    public Response $response;

    public function __construct(string $baseDir, $config) {
        self::$app = $this;
        self::$BASE_DIR = $baseDir;
        self::$db = new Database($config['db']);
        self::$config = $config;

        $this->request = new Request();
        $this->response = new Response();

        $this->router = new Router($this->request, $this->response);
    }

    public function run() {
        try {
            echo $this->router->resolve();
        } catch (BaseException $e) { // Catch the specific exception class you're using.
            $e->handle();
        } catch (\Exception $e) {
            echo $e;
        }
    }
}
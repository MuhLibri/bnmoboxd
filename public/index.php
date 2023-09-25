<?php

require_once __DIR__ . '/../src/core/Application.php';
require_once __DIR__ . '/../src/core/Router.php';
require_once __DIR__ . '/../src/core/Request.php';
require_once __DIR__ . '/../src/core/Response.php';
require_once __DIR__ . '/../src/core/Controller.php';
require_once __DIR__ . '/../src/core/Repository.php';
require_once __DIR__ . '/../src/controllers/FilmController.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';
require_once __DIR__ . '/../src/db/Database.php';

use app\core\Application;
use app\controllers\FilmController;
use app\controllers\AuthController;

$config = [
    'db' => [
        'db_name' => $_ENV['MYSQL_DATABASE'],
        'port' => $_ENV['MYSQL_PORT'],
        'host' => $_ENV['MYSQL_HOST'],
        'username' => $_ENV['MYSQL_USER'],
        'password' => $_ENV['MYSQL_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__), $config);
$app->router->get('/', function() {
    return 'Hello World';
});
$app->router->get("/test", function() {
    return 'test';
});
$app->router->get('/user/:id', function() {
    return Application::$app->request->getParams()[0];
});

$app->router->get('/login', [AuthController::class, 'loginPage']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->post('/film/:id', [FilmController::class, 'index']);

$app->run();
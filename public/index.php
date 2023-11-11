<?php

require_once __DIR__ . '/../src/core/Application.php';
require_once __DIR__ . '/../src/core/Router.php';
require_once __DIR__ . '/../src/core/Request.php';
require_once __DIR__ . '/../src/core/Response.php';
require_once __DIR__ . '/../src/core/Controller.php';
require_once __DIR__ . '/../src/core/Repository.php';
require_once __DIR__ . '/../src/core/Middleware.php';
require_once __DIR__ . '/../src/core/Service.php';
require_once __DIR__ . '/../src/controllers/FilmController.php';
require_once __DIR__ . '/../src/controllers/DashboardController.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';
require_once __DIR__ . '/../src/controllers/ReviewsController.php';
require_once __DIR__ . '/../src/controllers/ProfileController.php';
require_once __DIR__ . '/../src/controllers/CuratorsController.php';
require_once __DIR__ . '/../src/controllers/ApiController.php';
require_once __DIR__ . '/../src/controllers/SubscriptionController.php';
require_once __DIR__ . '/../src/exceptions/BaseException.php';
require_once __DIR__ . '/../src/exceptions/NotFoundException.php';
require_once __DIR__ . '/../src/exceptions/ForbiddenException.php';
require_once __DIR__ . '/../src/exceptions/BadRequestException.php';
require_once __DIR__ . '/../src/exceptions/InternalServerErrorException.php';
require_once __DIR__ . '/../src/exceptions/UnauthorizedException.php';
require_once __DIR__ . '/../src/db/Database.php';
require_once __DIR__ . '/../src/utils/utils.php';

use app\core\Application;
use app\controllers\DashboardController;
use app\controllers\FilmController;
use app\controllers\AuthController;
use app\controllers\ReviewsController;
use app\controllers\ProfileController;
use app\controllers\CuratorsController;
use app\controllers\ApiController;
use app\controllers\SubscriptionController;

if (!session_id()) {
    session_start();
};

$config = [
    'db' => [
        'db_name' => $_ENV['MYSQL_DATABASE'],
        'port' => $_ENV['MYSQL_PORT'],
        'host' => $_ENV['MYSQL_HOST'],
        'username' => $_ENV['MYSQL_USER'],
        'password' => $_ENV['MYSQL_PASSWORD'],
    ],
    'REST_API_URL' => $_ENV['REST_API_URL'],
    'REST_API_KEY' => $_ENV['REST_API_KEY'],
    'PHP_API_KEY' => $_ENV['PHP_API_KEY'],
    'SOAP_API_KEY' => $_ENV['SOAP_API_KEY']
];


$app = new Application(dirname(__DIR__), $config);
$app->router->get('/',[DashboardController::class, 'index']);
$app->router->get('/login', [AuthController::class, 'loginPage']);
$app->router->get('/register', [AuthController::class, 'registerPage']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->post('/logout', [AuthController::class, 'logout']);
$app->router->get('/films', [FilmController::class, 'index']);
$app->router->get('/films/search', [FilmController::class, 'search']);
$app->router->get('/film/:id', [FilmController::class, 'show']);
$app->router->get('/films/new', [FilmController::class, 'createPage']);
$app->router->get('/film/:id/edit', [FilmController::class, 'editPage']);
$app->router->post('/films/new', [FilmController::class, 'create']);
$app->router->post('/film/:id/edit', [FilmController::class, 'edit']);
$app->router->delete('/film/:id/delete', [FilmController::class, 'delete']);
$app->router->get('/my-reviews', [ReviewsController::class, 'index']);
$app->router->get('/my-reviews/search', [ReviewsController::class, 'search']);
$app->router->post('/my-reviews', [ReviewsController::class, 'create']);
$app->router->get('/my-reviews/:id', [ReviewsController::class, 'show']);
$app->router->post('/my-reviews/:id', [ReviewsController::class, 'edit']);
$app->router->delete('/my-reviews/:id', [ReviewsController::class, 'delete']);
$app->router->get('/profile', [ProfileController::class, 'index']);
$app->router->post('/profile/edit', [ProfileController::class, 'edit']);
$app->router->delete('/profile/delete', [ProfileController::class, 'delete']);
$app->router->get('/api/films', [ApiController::class, 'search']);
$app->router->get('/curators', [CuratorsController::class, 'index']);
$app->router->get('/curators/search', [CuratorsController::class, 'search']);
$app->router->get('/curators/:id', [CuratorsController::class, 'show']);
$app->router->post('/curators/:id/subscribe', [CuratorsController::class, 'subscribe']);
$app->router->put('/subscription', [SubscriptionController::class, 'update']);
$app->run();
<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Auth;
use App\Router;
use App\Controller\LoginController;
use App\Controller\NewsController;

$router = new Router();

$router->get('/', function () {
    $location = Auth::check() ? 'news' : 'login';
    header("Location: /$location");
    exit;
});
$router->get('/login', [LoginController::class, 'showForm']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);
$router->get('/news', [NewsController::class, 'index']);
$router->post('/news/create', [NewsController::class, 'save']);
$router->post('/news/delete', [NewsController::class, 'delete']);

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);


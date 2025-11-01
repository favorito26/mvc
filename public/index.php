<?php


require_once __DIR__.'/../vendor/autoload.php';

use app\controllers\SiteController;
use app\core\Application;
$app = new Application(dirname(__DIR__));

$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/about/contact', 'contact');

$app->router->post('/about/contact', [SiteController::class, 'handleContact']);

$app->router->get('/about', 'about');



$app->run();

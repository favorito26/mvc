<?php


require_once __DIR__.'/../vendor/autoload.php';

use app\core\Application;
$app = new Application(dirname(__DIR__));

$app->router->get('/', 'home');

$app->router->get('/about/contact', 'contact');

$app->router->post('/about/contact', function(){
    return 'handling post request';
});

$app->router->get('/about', 'about');



$app->run();
echo 'hello';


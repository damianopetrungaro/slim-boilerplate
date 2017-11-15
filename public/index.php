<?php

$container = require __DIR__ . '/../bootstrap/app.php';
$app = new \Slim\App($container);

$routes = scandir(__DIR__ . '/../app/Routes/');
foreach ($routes as $route) {
    if (is_file(__DIR__ . '/../app/Routes/' . $route) && mb_substr($route, -4, 4) === '.php') {
        require __DIR__ . '/../app/Routes/' . $route;
    }
}

$app->run();

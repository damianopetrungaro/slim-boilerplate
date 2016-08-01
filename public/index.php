<?php

require __DIR__ . '/../bootstrap/app.php';

$app = new \Slim\App();

require __DIR__ . '/../bootstrap/dependencies.php';

$routes = scandir(__DIR__ . '/../app/Routes/');
foreach ($routes as $route) {
    if (strpos($route, '.php')) {
        require __DIR__ . '/../app/Routes/' . $route;
    }
}

$app->run();

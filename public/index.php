<?php

require __DIR__ . '/../bootstrap/app.php';

use App\Services\Container;

$app = new Container();
$routes = scandir(__DIR__ . '/../app/Routes/');
foreach ($routes as $route) {
    if (strpos($route, '.php')) {
        require __DIR__ . '/../app/Routes/' . $route;
    }
}
$app->run();
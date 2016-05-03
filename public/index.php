<?php

require '../vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv('./../');
$dotenv->load();

use App\Services\Container;

$app = new Container();
require '../app/routes.php';
$app->run();
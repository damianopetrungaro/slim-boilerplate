<?php

require '../vendor/autoload.php';

use App\Services\Container;

$app = new Container();
require '../app/routes.php';
$app->run();
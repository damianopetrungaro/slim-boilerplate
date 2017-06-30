<?php

require __DIR__ . '/../vendor/autoload.php';
$container = require __DIR__ . '/container.php';

use Dotenv\Dotenv;

$dotenv = new Dotenv('./../');
$dotenv->load();
$container->get('db');

return $container;
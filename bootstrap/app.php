<?php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = new Dotenv('./../');
$dotenv->load();

require __DIR__ . '/database.php';
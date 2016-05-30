<?php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager;

$dotenv = new Dotenv('./../');
$dotenv->load();

require __DIR__ . '/../bootstrap/database.php';

$db = new Manager;
$db->addConnection($database);
$db->setAsGlobal();
$db->bootEloquent();

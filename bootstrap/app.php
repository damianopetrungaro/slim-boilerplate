<?php

use Illuminate\Database\Capsule\Manager;

$dotenv = new \Dotenv\Dotenv('./../');
$dotenv->load();

require '../bootstrap/database.php';

$db = new Manager;
$db->addConnection($database);
$db->setAsGlobal();
$db->bootEloquent();
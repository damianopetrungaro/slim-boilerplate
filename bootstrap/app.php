<?php

use Illuminate\Database\Capsule\Manager;

$dotenv = new \Dotenv\Dotenv('./../');
$dotenv->load();

require '../bootstrap/config.php';

$db = new Manager;
$db->addConnection($config['db']);
$db->setAsGlobal();
$db->bootEloquent();
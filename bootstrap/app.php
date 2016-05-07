<?php

require '../bootstrap/config.php';

use Illuminate\Database\Capsule\Manager;

$dotenv = new \Dotenv\Dotenv('./../');
$dotenv->load();


$db = new Manager;
$db->addConnection($config['db']);
$db->setAsGlobal();
$db->bootEloquent();
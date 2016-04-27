<?php

$app->get('/users', ['App\Controllers\UserController', 'index']);
$app->post('/users', ['App\Controllers\UserController', 'store']);
$app->get('/users/{id:[0-9]+}', ['App\Controllers\UserController', 'show']);
$app->put('/users/{id:[0-9]+}', ['App\Controllers\UserController', 'update']);

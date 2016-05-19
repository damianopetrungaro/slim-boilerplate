<?php

$app->delete('/users/{id:[0-9]+}', [ 'App\Controllers\UserController', 'delete' ]);
$app->put('/users/{id:[0-9]+}', [ 'App\Controllers\UserController', 'update' ]);
$app->get('/users/{id:[0-9]+}', [ 'App\Controllers\UserController', 'show' ]);
$app->post('/users', [ 'App\Controllers\UserController', 'store' ]);
$app->get('/users', [ 'App\Controllers\UserController', 'index' ]);

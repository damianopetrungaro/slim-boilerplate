<?php

$app->post('/auth/login', ['App\Controllers\AuthController', 'login']);
$app->post('/auth/reset', ['App\Controllers\AuthController', 'reset']);
$app->get('/auth/logout', ['App\Controllers\AuthController', 'logout']);
$app->get('/auth/logged', ['App\Controllers\AuthController', 'logged']);
$app->post('/auth/register', ['App\Controllers\AuthController', 'register']);

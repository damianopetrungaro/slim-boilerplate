<?php

$app->get('/users', function ($request, $response) use ($container) {
    $userRepository = $container->get('userRepository');

    $controller = new \App\Controllers\UserController($response, $userRepository, new \App\Transformers\Users\UserTransformer());
    return $controller->index();
});


$app->post('/users', function ($request, $response) use ($container) {

    $validator = $container->get('validator');
    $userRepository = $container->get('userRepository');

    $controller = new \App\Controllers\UserController($response, $userRepository, new \App\Transformers\Users\UserTransformer());
    return $controller->store($request, new \App\Validators\Users\StoreUserValidator($validator), new \App\Services\UserService($userRepository));
});


$app->get('/users/{id:[0-9]+}', function ($request, $response, $args) use ($container) {

    $userRepository = $container->get('userRepository');

    $controller = new \App\Controllers\UserController($response, $userRepository, new \App\Transformers\Users\UserTransformer());
    return $controller->show($args['id']);
});


$app->put('/users/{id:[0-9]+}', function ($request, $response, $args) use ($container) {

    $validator = $container->get('validator');
    $userRepository = $container->get('userRepository');

    $controller = new \App\Controllers\UserController($response, $userRepository, new \App\Transformers\Users\UserTransformer());
    return $controller->update($args['id'], $request, new \App\Validators\Users\UpdateUserValidator($validator), new \App\Services\UserService($userRepository));
});


$app->delete('/users/{id:[0-9]+}', function ($request, $response, $args) use ($container) {

    $userRepository = $container->get('userRepository');

    $controller = new \App\Controllers\UserController($response, $userRepository, new \App\Transformers\Users\UserTransformer());
    return $controller->delete($args['id']);
});

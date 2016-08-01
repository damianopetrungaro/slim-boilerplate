<?php

$container = $app->getContainer();

$container['response'] = function () {
    return new \App\Responses\ApiResponse();
};

$container['errorHandler'] = function () {
    return function ($request, \App\Responses\ApiResponse $response, \Exception $exception) {

        if ($exception instanceof App\Exceptions\GenericException) {
            return $response->error($exception->getTitle(), $exception->getDetails(), $exception->getStatus());
        }

        if ($exception instanceof App\Exceptions\JWTException) {
            $response = new \App\Responses\ApiResponse();

            return $response->error($exception->getTitle(), $exception->getMessage(), 500);
        }

        return $response->error('Something went wrong', (getenv('DEBUG')) ? $exception->getMessage() : 'Contact the admin', 500);
    };
};

$container['notFoundHandler'] = function () {
    return function ($request, \App\Responses\ApiResponse $response) {
        return $response->error('Page not found', "This page at the moment doesn't exists", 404);
    };
};

$container['notAllowedHandler'] = function () {
    return function ($request, \App\Responses\ApiResponse $response, $methods) {
        return $response->error('Method not allowed', "Sorry but this method is not available for this resource", 405, ['Method allowed for this endpoint are: ' . implode(', ', $methods)]);
    };
};

$container['validator'] = function () {
    return new Valitron\Validator($_POST, [], 'en');
};

$container['jwt'] = function (\Slim\Container $container) {
    $config = [
        'header-param' => getenv('JWT_HEADER_PARAMS'),
        'issuer' => getenv('JWT_ISSUER'),
        'audience' => getenv('JWT_AUDIENCE'),
        'id' => getenv('JWT_ID'),
        'sign' => getenv('JWT_SIGN'),
    ];

    return new App\Acme\JWT\JWT($container->get('request'), new Lcobucci\JWT\Builder(), new \Lcobucci\JWT\Signer\Hmac\Sha256(), new \Lcobucci\JWT\Parser(), new \Lcobucci\JWT\ValidationData(), $config);
};

$container['authService'] = function (\Slim\Container $container) {
    $jwt = $container->get('jwt');
    $userRepository = $container->get('userRepository');
    return new \App\Services\AuthService($userRepository, $jwt);
};

$container['db'] = function () use ($db){
    return $db->getConnection();
};

$container['userRepository'] = function () {
    return new App\Repositories\Users\UserEloquentRepository(new \App\Models\User());
};
<?php

$entires = [];

$entires['response'] = function () {
    return new \App\Responses\ApiResponse();
};

$entires['logger'] = function () {
    $logger = new \Monolog\Logger('app');
    $file = new \Monolog\Handler\RotatingFileHandler('../logs/app.log', \Monolog\Logger::DEBUG);
    $logger->pushHandler($file);
    return $logger;
};

$entires['errorHandler'] = function (\Slim\Container $container) {
    return function ($request, \App\Responses\ApiResponse $response, $exception) use ($container) {

        if ($exception instanceof App\Exceptions\GenericException) {
            return $response->error($exception->getTitle(), $exception->getDetails(), $exception->getStatus());
        }

        if ($exception instanceof App\Exceptions\JWTException) {
            $response = new \App\Responses\ApiResponse();

            return $response->error($exception->getTitle(), $exception->getMessage(), 500);
        }

        // Add custom error here

        $uuid = \Ramsey\Uuid\Uuid::uuid1();

        $container->get('logger')->addError($exception->getMessage(), [
            'uuid' => $uuid->toString(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ]);

        return $response->error('Something went wrong', (getenv('DEBUG') === '1') ? $exception->getMessage() : 'Contact the admin', 500, [], $uuid);
    };
};

$entires['notFoundHandler'] = function () {
    return function ($request, \App\Responses\ApiResponse $response) {
        return $response->error('Page not found', "This page at the moment doesn't exists", 404);
    };
};

$entires['notAllowedHandler'] = function () {
    return function ($request, \App\Responses\ApiResponse $response, $methods) {
        return $response->error('Method not allowed', "Sorry but this method is not available for this resource", 405, ['Method allowed for this endpoint are: ' . implode(', ', $methods)]);
    };
};

$entires['phpErrorHandler'] = function (\Slim\Container $container) {
    return $container->get('errorHandler');
};

$entires['validator'] = function (\Slim\Container $container) {
    $request = $container->get('request');
    return new Valitron\Validator($request->getParsedBody(), [], 'en');
};

$entires['jwt'] = function (\Slim\Container $container) {
    $config = [
        'header-param' => getenv('JWT_HEADER_PARAMS'),
        'issuer' => getenv('JWT_ISSUER'),
        'audience' => getenv('JWT_AUDIENCE'),
        'id' => getenv('JWT_ID'),
        'sign' => getenv('JWT_SIGN'),
    ];

    return new App\Acme\JWT\JWT($container->get('request'), new Lcobucci\JWT\Builder(), new \Lcobucci\JWT\Signer\Hmac\Sha256(), new \Lcobucci\JWT\Parser(), new \Lcobucci\JWT\ValidationData(), $config);
};

$entires['authService'] = function (\Slim\Container $container) {
    $jwt = $container->get('jwt');
    $userRepository = $container->get('userRepository');
    return new \App\Services\AuthService($userRepository, $jwt);
};

$entires['db'] = function () {

    $connection = new Illuminate\Database\Capsule\Manager();
    $connection->addConnection([
        'driver' => 'mysql',
        'host' => getenv('DB_HOST') ?: 'localhost',
        'database' => getenv('DB_NAME') ?: 'db',
        'username' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: 'root',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
        'unix_socket' => getenv('DB_UNIX_SOCKET') ?: null,
    ]);

    $connection->setAsGlobal();
    $connection->bootEloquent();

    return $connection->getConnection();
};

$entires['mailer'] = function () {
    return \App\Acme\Helpers\Mailer::fromArray([
        'host' => getenv('SMTP_HOST'),
        'port' => getenv('SMTP_PORT'),
        'encryption' => getenv('SMTP_ENCRYPTION'),
        'username' => getenv('SMTP_USERNAME'),
        'password' => getenv('SMTP_PASSWORD'),
        'name' => getenv('SMTP_NAME')
    ]);
};

$entires['userRepository'] = function () {
    return new App\Repositories\Users\UserEloquentRepository(new \App\Models\User());
};


return new \Slim\Container($entires);
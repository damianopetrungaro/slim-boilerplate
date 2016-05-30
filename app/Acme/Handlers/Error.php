<?php

namespace App\Acme\Handlers;

use App\Responses\ApiResponse;
use App\Exceptions\JWTException;
use Slim\Handlers\Error as BaseError;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Error extends BaseError
{
    public function __construct($displayErrorDetails)
    {
        parent::__construct($displayErrorDetails);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, \Exception $exception)
    {
        if ($exception instanceof JWTException) {
            $response = new ApiResponse();

            return $response->error($exception->getTitle(), $exception->getMessage(), 500);
        }

        // Add custom Error here

        return parent::__invoke($request, $response, $exception);
    }
}

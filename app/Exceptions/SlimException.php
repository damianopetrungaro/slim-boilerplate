<?php

namespace App\Exceptions;

use Slim\Handlers\Error;
use App\Responses\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SlimException extends Error
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

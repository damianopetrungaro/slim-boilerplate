<?php

namespace App\Responses;

use Ramsey\Uuid\Uuid;
use Slim\Http\Response;

class ApiResponse extends Response
{

    public function errorValidation(array $data)
    {
        $response                      = [ ];
        $response['id']                = Uuid::uuid1();
        $response['source']['pointer'] = $data;
        $response['status']            = 400;

        return $this->withJson($response, 400);
    }
}
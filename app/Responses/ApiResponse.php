<?php

namespace App\Responses;

use Slim\Http\Response;
use Ramsey\Uuid\Uuid;

class ApiResponse extends Response
{

    public function errorValidation(array $data)
    {
        $response                      = [ ];
        $response['id']                = Uuid::uuid1();
        $response['title']             = 'Validation error';
        $response['detail']            = 'Some fields are not correctly sent';
        $response['source']['pointer'] = $data;
        $response['status']            = 400;

        return $this->withJson([ 'error' => $response ], 400);
    }


    public function error($title, $message, $status, $data = [ ])
    {

        $response                      = [ ];
        $response['id']                = Uuid::uuid1();
        $response['title']             = $title;
        $response['detail']            = $message;
        $response['source']['pointer'] = $data;
        $response['status']            = $status;

        return $this->withJson([ 'error' => $response ], $status);
    }


    public function success($data, $status = 200)
    {
        return $this->withJson([ 'data' => $data ], $status);
    }
}
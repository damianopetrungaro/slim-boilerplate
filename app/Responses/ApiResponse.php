<?php

declare(strict_types=1);

namespace App\Responses;

use Ramsey\Uuid\Uuid;
use Slim\Http\Response;

class ApiResponse extends Response
{
    /**
     * Return a Bad Validation Response
     *
     * @param array $data
     *
     * @return Response
     */
    public function errorValidation(array $data): Response
    {
        $response = [];
        $response['id'] = Uuid::uuid1();
        $response['title'] = 'Validation error';
        $response['detail'] = 'Some fields are not correctly sent';
        $response['source']['pointer'] = $data;
        $response['status'] = 400;

        return $this->withJson(['error' => $response], 400);
    }

    /**
     * Return a Bad Response
     *
     * @param string $title
     * @param string $message
     * @param int $status
     * @param array $data
     * @param Uuid|null $uuid
     *
     * @return Response
     */
    public function error(string $title, string $message, int $status, $data = [], Uuid $uuid = null): Response
    {
        $response = [];
        $response['id'] = ($uuid == null) ? Uuid::uuid1() : $uuid;
        $response['title'] = $title;
        $response['detail'] = $message;
        $response['source']['pointer'] = $data;
        $response['status'] = $status;

        return $this->withJson(['error' => $response], $status);
    }

    /**
     * Return a successful Response
     * @param $data
     * @param int $status
     *
     * @return Response
     */
    public function success($data, $status = 200): Response
    {
        return $this->withJson(['data' => $data], $status);
    }
}

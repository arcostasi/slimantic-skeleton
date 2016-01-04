<?php

namespace App\Provider;

use Psr\Http\Message\ResponseInterface as Response;

class JsonViewProvider
{
    /**
     * JSON render response.
     *
     * @param  Response $response
     * @param  array $data Associative array of data to be returned
     * @param  int $status HTTP status code
     * @return Response
     */
    public function render(Response $response, $data = [], $status = 200)
    {
        // Set status code
        $status = intval($status);
        // Set content-type
        $json = $response->withStatus($status)
            ->withHeader('Content-Type', 'application/json; charset=UTF-8');
        // Set content body
        $json->getBody()
            ->write(json_encode($data));

        return $json;
    }
}
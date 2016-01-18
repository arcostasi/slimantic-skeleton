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
        // Return JSON response
        return $response->withJson($data, $status);
    }
}
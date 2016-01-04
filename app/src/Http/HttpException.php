<?php

namespace App\Http;

use Slim\Http\Response;

/**
 * HttpException.
 */
class HttpException extends \RuntimeException implements HttpExceptionInterface
{
    private $statusCode;
    private $headers;

    public function __construct($message = null, $statusCode = 400, \Exception $previous = null, array $headers = array(), $code = 0)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;

        // Get status phrase
        if (!$message && is_integer($statusCode) && $statusCode > 100 && $statusCode < 599) {
            $response = new Response($statusCode);
            $message = $response->getReasonPhrase();
        }

        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}
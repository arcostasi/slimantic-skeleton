<?php

namespace App\Exceptions;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Handler
{
    private $container;
    private $settings;
    private $view;
    private $json;
    private $log;

    /**
     * Contructor Handler.
     *
     * @param \Interop\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->settings = $container->get('settings');
        $this->view = $container->get('view');
        $this->json = $container->get('json');
        $this->log = $container->get('logger');
    }

    /**
     * Render an exception into an HTTP or JSON response.
     *
     * @param Request $request
     * @param Response $response
     * @param \Exception $exception
     * @return mixed
     */
    public function render(Request $request, Response $response, \Exception $exception)
    {
        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 400;
        $response->withStatus($statusCode);

        $debug = $this->settings['displayErrorDetails'] == 'true' ? true : false;

        $title = $debug ? 
            'The application could not run because of the following error:' : 
            'A website error has occurred. Sorry for the temporary inconvenience.';

        $header = $request->getHeaders();
        $message = $exception->getMessage();

        $json = isset($header['HTTP_CONTENT_TYPE'][0]) && $header['HTTP_CONTENT_TYPE'][0] == 'application/json';

        // Check content-type is application/json
        if ($json) {
            // Define content-type to json
            $response->withHeader('Content-Type', 'application/json');

            $error = [
                'status' => 'error',
                'error' => $title,
                'statusCode' => $statusCode
            ];

            // Check debug
            if ($debug) {
                $error['details'] = [
                    'message' => $message,
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'code' => $exception->getCode()
                ];
            }

            $view = $this->json->render($response, $error, $statusCode);
        } else {
            // Define content-type to html
            $response->withHeader('Content-Type', 'text/html');
            $message = sprintf('<span>%s</span>', htmlentities($message));

            $error = [
                'type' => get_class($exception),
                'message' => $message
            ];

            // Check debug
            if ($debug) {
                $trace = $exception->getTraceAsString();
                $trace = sprintf('<pre>%s</pre>', htmlentities($trace));
                $error['file'] = $exception->getFile();
                $error['line'] = $exception->getLine();
                $error['code'] = $exception->getCode();
                $error['trace'] = $trace;
            }

            $error['debug'] = $debug;
            $error['title'] = $title;

            $view = $this->view->render($response, 'error/error.twig', $error);
        }

        // Send error to log
        $this->log->addError($exception->getMessage());

        return $view;
    }

    /**
     * Render an Not Found (404) exception into an HTTP response.
     *
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function renderNotFound(Request $request, Response $response)
    {
        // Define status and content-type to html
        $response->withStatus(404)
            ->withHeader('Content-Type', 'text/html');

        return $this->view->render($response, 'error/error404.twig');
    }

    /**
     * Render an Not Allowed (405) exception into an HTTP response.
     *
     * @param Request $request
     * @param Response $response
     * @param array $methods
     * @return mixed
     */
    public function renderNotAllowed(Request $request, Response $response, array $methods)
    {
        // Define status and content-type to html
        $response->withStatus(405)
            ->withHeader('Content-Type', 'text/html');

        // Define allow methods
        $allow = implode(', ', $methods);

        return $this->view->render($response, 'error/error405.twig', compact('allow'));
    }
}
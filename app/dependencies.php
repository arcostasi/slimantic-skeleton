<?php

// Get application container
$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Twig
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new \Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

$container['json'] = function ($c) {
    return new \App\Provider\JsonViewProvider();
};

$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $settings = $c->get('settings');
        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 400;

        $c['response']->withStatus($statusCode);

        $debug = $settings['displayErrorDetails'] == 'true' ? true : false;

        $title = $debug ? 
            'The application could not run because of the following error:' : 
            'A website error has occurred. Sorry for the temporary inconvenience.';

        $header = $request->getHeaders();
        $message = $exception->getMessage();

        $json = isset($header['HTTP_CONTENT_TYPE'][0]) && $header['HTTP_CONTENT_TYPE'][0] == 'application/json';

        // Check content-type is application/json
        if ($json) {
            $c['response']->withHeader('Content-Type', 'application/json');
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
        } else {
            $c['response']->withHeader('Content-Type', 'text/html');
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
        }

        if ($json) {
            $view = $c['json']->render($c['response'], $error, $statusCode);
        } else {
            $error['debug'] = $debug;
            $error['title'] = $title;
            $view = $c['view']->render($c['response'], 'error/error.twig', $error);
        }

        return $view;
    };
};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $c['response']->withStatus(404)
              ->withHeader('Content-Type', 'text/html');
        return $c['view']->render($c['response'], 'error/error404.twig');
    };
};

$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        $c['response']->withStatus(405)
              ->withHeader('Content-Type', 'text/html');
        $allow = implode(', ', $methods);
        return $c['view']->render($c['response'], 'error/error405.twig', $allow);
    };
};

// Flash messages
$container['flash'] = function ($c) {
    return new \Slim\Flash\Messages;
};

// Service databases
$container['database'] = function ($c) {
    $settings = $c->get('settings');
    $default = $settings['database']['connections'][$settings['database']['default']];

    // Capsule aims to make configuring the library for usage outside of the
    // Laravel framework as easy as possible.
    $database = new \App\Provider\DatabaseProvider($default);

    return $database;
};

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// Monolog settings
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new \Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['logger']['path'], \Monolog\Logger::DEBUG));

    return $logger;
};

// -----------------------------------------------------------------------------
// Controller factories
// -----------------------------------------------------------------------------

$container['App\Controller\IndexController'] = function ($c) {
    return new App\Controller\IndexController($c->get('view'), $c->get('json'), $c->get('logger'));
};

$container['App\Controller\UserController'] = function ($c) {
    return new App\Controller\UserController($c->get('view'), $c->get('json'), $c->get('logger'), $c->get('database'));
};
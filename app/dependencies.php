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
        $handler = new \App\Exceptions\Handler($c);
        return $handler->render($request, $response, $exception);
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
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['logger']['path'], \Monolog\Logger::DEBUG));

    return $logger;
};

// -----------------------------------------------------------------------------
// Controller factories
// -----------------------------------------------------------------------------

$container['App\Controller\BaseController'] = function ($c) {
    return new App\Controller\BaseController($c);
};
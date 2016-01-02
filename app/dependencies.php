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
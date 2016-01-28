<?php

date_default_timezone_set('UTC');

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('DATA_PATH', ROOT_PATH . '/data');
define('CACHE_PATH', DATA_PATH . '/cache');
define('LOG_PATH', DATA_PATH . '/log');

chdir(ROOT_PATH);

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

// Load all class
require_once ROOT_PATH . '/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(ROOT_PATH);
$dotenv->load();

// Load application settings
$settings = require_once APP_PATH . '/settings.php';

// Create container for application
$container = new \Slim\Container($settings);

// Create new application
$app = new \Slim\App($container);

session_start();

// Set up dependencies
require APP_PATH . '/dependencies.php';

// Register middlewares
require APP_PATH . '/middleware.php';

// Register routes
require APP_PATH . '/routes.php';

// Run!
$app->run();
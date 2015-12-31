<?php

date_default_timezone_set('UTC');

define('PATH_ROOT', dirname(__DIR__));
define('PATH_APP', PATH_ROOT . '/app');
define('PATH_DATA', PATH_ROOT . '/data');
define('PATH_CACHE', PATH_DATA . '/cache');
define('PATH_LOG', PATH_DATA . '/log');

chdir(dirname(__DIR__));

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require PATH_ROOT . '/vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require PATH_APP . '/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require PATH_APP . '/dependencies.php';

// Register middlewares
require PATH_APP . '/middleware.php';

// Register routes
require PATH_APP . '/routes.php';

// Run!
$app->run();
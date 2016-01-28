<?php

return [
    'settings' => [
        // Error Handler
        'displayErrorDetails' => getenv('APP_DEBUG'),
        // View settings
        'view' => [
            'template_path' => APP_PATH . '/view',
            'twig' => [
                'cache' => CACHE_PATH . '/twig',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],

        // Monolog settings
        'logger' => [
            'name' => 'app',
            'path' => LOG_PATH . '/app.log',
        ],

        // Database settings
        'database' => [
            'default' => getenv('DB_CONNECTION'),
            'connections' => [
                'sqlite' => [
                    'driver' => 'sqlite',
                    'database' => DATA_PATH . '/database.sqlite',
                    'prefix' => '',
                ],
                'pgsql' => [
                    'driver' => 'pgsql',
                    'host' => getenv('DB_HOST'),
                    'database' => getenv('DB_DATABASE'),
                    'username' => getenv('DB_USERNAME'),
                    'password' => getenv('DB_PASSWORD'),
                    'charset' => 'utf8',
                    'prefix' => '',
                    'schema' => getenv('DB_SCHEMA'),
                ],
            ]
        ],

        // Model settings
        'model' => [
            'factory' => [
                'user' => App\Model\UserModel::class,
                'password' => App\Model\PasswordResetModel::class
            ]
        ]
    ],
];
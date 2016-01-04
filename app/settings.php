<?php

return [
    'settings' => [
        // Error Handler
        'displayErrorDetails' => getenv('APP_DEBUG'),
        // View settings
        'view' => [
            'template_path' => PATH_APP . '/view',
            'twig' => [
                'cache' => PATH_CACHE . '/twig',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],

        // Monolog settings
        'logger' => [
            'name' => 'app',
            'path' => PATH_LOG . '/app.log',
        ],

        // Database settings
        'database' => [
            'default' => getenv('DB_CONNECTION'),
            'connections' => [
                'sqlite' => [
                    'driver' => 'sqlite',
                    'database' => PATH_DATA . '/database.sqlite',
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
        ]
    ],
];
<?php

return [
    'settings' => [
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
                    'host' => 'localhost',
                    'database' => '',
                    'username' => '',
                    'password' => '',
                    'charset' => 'utf8',
                    'prefix' => '',
                    'schema' => 'public',
                ],
            ]
        ]
    ],
];
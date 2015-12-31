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

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => PATH_LOG . '/app.log',
        ],
    ],
];
<?php

// Routes
$app->get('/', 'App\Controller\IndexController:index')
    ->setName('homepage');

$app->get('/test', 'App\Controller\IndexController:test')
    ->setName('test');

$app->get('/user', 'App\Controller\UserController:index')
    ->setName('user');
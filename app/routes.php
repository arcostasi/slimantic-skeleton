<?php

// Routes
$app->get('/', 'App\Controller\IndexController:index')
    ->setName('homepage');

$app->get('/user', 'App\Controller\UserController:index')
    ->setName('user');
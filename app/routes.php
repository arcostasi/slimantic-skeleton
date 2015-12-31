<?php

// Routes
$app->get('/', 'App\Controller\IndexController:index')
    ->setName('homepage');

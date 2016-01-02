<?php

namespace App\Controller;

use App\Provider\JsonViewProvider as JsonView;
use Slim\Views\Twig as View;
use Psr\Log\LoggerInterface;

class BaseController
{
    protected $view;
    protected $json;
    protected $logger;
    protected $database;

    /**
     * Contructor Controller.
     *
     * @param View $view
     * @param JsonView $json
     * @param LoggerInterface $logger
     */
    public function __construct(View $view, JsonView $json, LoggerInterface $logger)
    {
        $this->view = $view;
        $this->json = $json;
        $this->logger = $logger;
    }
}
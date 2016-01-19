<?php

namespace App\Controller;

use Interop\Container\ContainerInterface;

class BaseController
{
    protected $container;

    /**
     * Contructor Controller.
     *
     * @param \Interop\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
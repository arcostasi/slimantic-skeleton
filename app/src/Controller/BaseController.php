<?php

namespace App\Controller;

use Interop\Container\ContainerInterface;

/**
 * Class Base Controller.
 *
 * @package App\Controller
 */
abstract class BaseController
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
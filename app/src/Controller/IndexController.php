<?php

namespace App\Controller;

use App\Exceptions\HttpException;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class Index Controller.
 *
 * @package App\Controller
 */
class IndexController
{
    /** @var \Slim\Views\Twig */
    private $view;

    /**
     * IndexController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->view = $container->get('view');
    }

    /**
     * Index Action.
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function index(Request $request, Response $response, $args)
    {
        $this->view->render($response, 'index/home.twig');

        return $response;
    }

    /**
     * Test exception.
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     */
    public function test(Request $request, Response $response, $args)
    {
        throw new HttpException('Erro de Authenticação');
    }
}
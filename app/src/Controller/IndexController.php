<?php

namespace App\Controller;

use App\Http\HttpException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Index Controller.
 *
 * @package App\Controller
 */
class IndexController extends BaseController
{
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
     * @return App\Http\HttpException
     */
    public function test(Request $request, Response $response, $args)
    {
        throw new HttpException('Erro de Authenticação');
    }
}
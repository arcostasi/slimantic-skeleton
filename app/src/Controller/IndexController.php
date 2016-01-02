<?php

namespace App\Controller;

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
}
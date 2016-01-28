<?php

namespace App\Controller;

use App\Exceptions\HttpException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class Index Controller.
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
        $view = $this->get('view');

        return $view->render($response, 'index/home.twig');
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
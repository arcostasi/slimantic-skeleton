<?php

namespace App\Controller;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class User Controller.
 *
 * @package App\Controller
 */
class UserController extends BaseController
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
        // Get JSON view
        /** @var \App\Provider\JsonViewProvider $json */
        $json = $this->get('json');

        /** @var \App\Model\UserModel $user */
        $user = $this->get('user');

        // Get all users like array
        $list = $user->all()->toArray();

        return $json->render($response, $list);
    }
}
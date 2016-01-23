<?php

namespace App\Controller;

use App\Model\UserModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class User Controller.
 *
 * @package App\Controller
 */
class UserController extends BaseController
{
    /** @var \App\Provider\DatabaseProvider */
    private $db;

    /** @var \App\Provider\JsonViewProvider */
    private $json;


    /**
     * UserController constructor.
     *
     * UserController constructor.
     * @param $container
     */
    public function __construct($container)
    {
        parent::__construct($container);

        $this->db = $container->get('database');
        $this->json = $container->get('json');
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
        $user = UserModel::all()->toArray();

        return $this->json->render($response, $user);
    }
}
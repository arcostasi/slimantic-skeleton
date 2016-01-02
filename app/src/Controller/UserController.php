<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Provider\DatabaseProvider as Database;
use App\Provider\JsonViewProvider as JsonView;
use Slim\Views\Twig as View;
use Psr\Log\LoggerInterface as Logger;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class User Controller.
 *
 * @package App\Controller
 */
class UserController extends BaseController
{
    private $db;

    /**
     * UserController constructor.
     *
     * @param View $view
     * @param JsonView $json
     * @param Logger $logger
     * @param Database $database
     */
    public function __construct(View $view, JsonView $json, Logger $logger, Database $database)
    {
        parent::__construct($view, $json, $logger);

        $this->db = $database;
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
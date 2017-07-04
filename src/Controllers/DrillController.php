<?php
namespace Controllers;

// Composer
use Praline\Error\{BadRequest, UserError};
use Praline\Slim\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

class DrillController extends Controller
{
    public function __construct($container)
    {

    }

    public function userError(Request $request, Response $response)
    {
        throw new UserError(400, 'Drill a UserError', 1);
    }

    public function badRequest(Request $request, Response $response)
    {
        throw new BadRequest('Drill a BadRequest', 11);
    }

    public function exception(Request $request, Response $response)
    {
        throw new \Exception('Drill an Exception', 21);
    }
}

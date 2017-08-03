<?php
/**
 * Created by PhpStorm.
 * User: slimek.wu
 * Date: 2017/7/10
 * Time: 下午 05:09
 */

namespace Controllers;

use Praline\Slim\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

class FilterController extends Controller
{
    public function __construct($container)
    {
    }

    public function traceIp(Request $request, Response $response)
    {
        $result = [
            'ipAddress' => $request->getAttribute('ip_address'),
        ];

        return $this->withJson($response, $result);
    }
}

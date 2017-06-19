<?php
namespace Controllers;

// Composer
use Slim\Http\Request;
use Slim\Http\Response;

class InspectController
{
    public function __construct($container)
    {

    }

    // 查看 Body 拆解出 parameters 之後的內容
    public function viewBody(Request $request, Response $response)
    {
        $params = $request->getParsedBody();

        $result = [
            'method' => $request->getMethod(),
            'params' => $params,
        ];

        return $response->withJson($result);
    }
}

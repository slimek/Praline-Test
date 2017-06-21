<?php

//======================================================================================================================
// Routes
// - 將 HTTP 請求分派給適當的 Controllers
//======================================================================================================================

use Slim\Http\Request;
use Slim\Http\Response;
use Praline\Utils\LetterCase;

// Middleware
$routeLogger = new Praline\Slim\Middleware\RouteLogger($app->getContainer());

//----------------------------------------------------------------------------------------------------------------------
// 獨立 Actions
//----------------------------------------------------------------------------------------------------------------------

$app->get('/phpinfo', function (Request $request, Response $response) {

    echo phpinfo();
    return $response;

})->add($routeLogger);

//----------------------------------------------------------------------------------------------------------------------
// 泛用分派
//----------------------------------------------------------------------------------------------------------------------

$app->post('/{controller}/{action}', function (Request $request, Response $response, $args) {

    $className = 'Controllers\\' . LetterCase::kebabToPascal($args['controller']) . 'Controller';
    $methodName = LetterCase::kebabToCamel($args['action']);

    $controller = new $className($this);
    return $controller->{$methodName}($request, $response);

})->add($routeLogger);

<?php

//======================================================================================================================
// Routes
// - 將 HTTP 請求分派給適當的 Controllers
//======================================================================================================================

use Slim\Http\Request;
use Slim\Http\Response;
use Praline\LetterCase;

//----------------------------------------------------------------------------------------------------------------------
// 獨立 Actions
//----------------------------------------------------------------------------------------------------------------------

$app->get('/phpinfo', function (Request $request, Response $response) {

    echo phpinfo();
    return $response;
});

//----------------------------------------------------------------------------------------------------------------------
// Inspect Controller
//----------------------------------------------------------------------------------------------------------------------

$app->any('/inspect/{action}', function (Request $request, Response $response, $args) {

    $controller = new Controllers\InspectController($this);
    $methodName = LetterCase::kebabToCamel($args['action']);
    return $controller->{$methodName}($request, $response);
});

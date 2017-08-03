<?php

//======================================================================================================================
// Routes
// - 將 HTTP 請求分派給適當的 Controllers
//======================================================================================================================

use Slim\Http\Request;
use Slim\Http\Response;
use Praline\Utils\LetterCase;

$container = $app->getContainer();

// Middleware
$routeLogger = new Praline\Slim\Middleware\RouteLogger($container);

//----------------------------------------------------------------------------------------------------------------------
// 獨立 Actions
//----------------------------------------------------------------------------------------------------------------------

$app->get('/phpinfo', function (Request $request, Response $response) {

    echo phpinfo();
    return $response;

})->add($routeLogger);

//----------------------------------------------------------------------------------------------------------------------
// Session Controller
// - 測試身份認證流程
//----------------------------------------------------------------------------------------------------------------------

$app->post('/session/proceed', function (Request $request, Response $response) {

    $controller = new Controllers\SessionController($this);
    return $controller->proceed($request, $response);

})->add(new Praline\Slim\Middleware\SessionAuthorizer($container));

//----------------------------------------------------------------------------------------------------------------------
// Filter Controller
// - 測試 IP 篩選
//----------------------------------------------------------------------------------------------------------------------

$app->get('/filter/trace-ip', function (Request $request, Response $response) {

    $controller = new Controllers\FilterController($this);
    return $controller->traceIp($request, $response);

})->add(new Praline\Slim\Middleware\IpAddressFilter($container, ['61.216.82.121']));

//----------------------------------------------------------------------------------------------------------------------
// 泛用分派
// - 注意：如果呼叫 API 時的 controller 名稱打錯，會顯示找不到 XxxController.php 檔案的錯誤訊息
//----------------------------------------------------------------------------------------------------------------------

$app->any('/{controller}/{action}', function (Request $request, Response $response, $args) {

    $className = 'Controllers\\' . LetterCase::kebabToPascal($args['controller']) . 'Controller';
    $methodName = LetterCase::kebabToCamel($args['action']);

    $controller = new $className($this);
    return $controller->{$methodName}($request, $response);

})->add($routeLogger);

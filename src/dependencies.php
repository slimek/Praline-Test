<?php

//======================================================================================================================
// Dependency Injection
//======================================================================================================================

$container = $app->getContainer();

//----------------------------------------------------------------------------------------------------------------------
// Logging
//----------------------------------------------------------------------------------------------------------------------

$container[Praline\ContainerIds::LOGGER] = function ($container) {

    $logger = new Monolog\Logger('praline-test');

    // 相對於 public/index.php 的路徑，
    // %F 會由 strftime() 替換為日期時間
    $path = strftime('../log/praline-test_%F.log');
    $handler = new Monolog\Handler\StreamHandler($path);
    $handler->setFormatter(new Monolog\Formatter\LineFormatter(null, null, true, true));
    $logger->pushHandler($handler);

    return $logger;
};

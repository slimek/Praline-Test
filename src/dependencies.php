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

    // 透過 Fluentd 輸出 log
    $handler = new \Praline\Monolog\MonologFluentHandler('fluentd');  // 這是 docker-compose.yml 裡面的服務名稱
    $logger->pushHandler($handler);

    return $logger;
};

//----------------------------------------------------------------------------------------------------------------------
// Session Manager
//----------------------------------------------------------------------------------------------------------------------

$container[Praline\ContainerIds::SESSION_MANAGER] = function ($container) {

    $dataDir = '../data/';  // 附註：FilesystemCachePool 會自己建立 cache 子目錄

    $adapter = new League\Flysystem\Adapter\Local('../data/');
    $filesystem = new League\Flysystem\Filesystem($adapter);
    $pool = new Cache\Adapter\Filesystem\FilesystemCachePool($filesystem);
    $sessionManager = new Praline\Session\SessionManager($pool, $container);

    return $sessionManager;
};

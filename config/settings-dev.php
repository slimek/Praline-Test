<?php

// 在 Docker 容器中運行的組態檔

return [

    // Slim Framework Settings

    'displayErrorDetails' => true,    // 在 production 環境設為 false，其他環境設為 true
    'addContentLengthHeader' => false, // Slim Framework 的說明文件建議設為 false，所以我們照做～
];

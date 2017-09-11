<?php
return [
    'settings' => [
        "determineRouteBeforeAppMiddleware" => true,
        // set to false in production
        'displayErrorDetails' => true,
        // Allow the web server to send the content-length header
        'addContentLengthHeader' => false,
        'logger' => [
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'views_loader' => [
            'directories' => [
                dirname(__DIR__) . DIRECTORY_SEPARATOR . "templates"
            ]
        ],
    ],
];

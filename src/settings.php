<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        // Monolog settings
        'logger' => [
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'views_loader' => [
            'directories' => [
                dirname(__DIR__) . DIRECTORY_SEPARATOR ."templates"
            ]
        ],
    ],
];

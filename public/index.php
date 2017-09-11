<?php
use Batchy\Utils\Server;

require dirname(__DIR__) . '/vendor/autoload.php';

if (Server::parseCliRequest()) {
    return false;
}

session_start();
$settings = require dirname(__DIR__) . '/src/settings.php';
$app = new \Slim\App($settings);

Server::parseMiddleware($app, dirname(__DIR__) . '/core.middleware.yml');
Server::parseRoutes($app, dirname(__DIR__) . '/core.routes.yml');
Server::parseServices($app, dirname(__DIR__) . '/core.services.yml');

$app->run();

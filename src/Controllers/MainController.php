<?php
namespace Batchy\Controllers;

use Batchy\Services\LoggerService;
use Batchy\Services\TwigService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Twig_Environment;

class MainController
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function main(
        RequestInterface $request,
        ResponseInterface $response,
        $args
    ) {
        /** @var LoggerService $logger */
        $logger = $this->container->get('logger');
            $logger->getLogger()->info("Route: '/'");

        /** @var TwigService $render_service */
        $render_service = $this->container->get('views');

        // Render index view
        $response->getBody()
            ->write($render_service->render('index.html.twig'));
    }
}
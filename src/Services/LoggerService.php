<?php
namespace Batchy\Services;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;

class LoggerService
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getLogger($name = 'batchy')
    {
        $settings = $this->container->get('settings')['logger'];
        $logger = new Logger($name);

        $logger->pushProcessor(new UidProcessor());

        $logger->pushHandler(
            new StreamHandler($settings['path'], $settings['level'])
        );

        return $logger;
    }


}
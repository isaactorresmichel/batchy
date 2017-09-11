<?php
namespace Batchy\Services;

use Psr\Container\ContainerInterface;
use Twig_Environment;
use Twig_Loader_Chain;
use Twig_Loader_Filesystem;
use Twig_LoaderInterface;

class TwigService
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Twig views loader.
     * @return \Twig_Loader_Chain
     */
    public function getLoaders()
    {
        $settings = $this->container->get('settings')['views_loader'];

        $loader = new Twig_Loader_Chain();

        if (isset($settings['directories'])) {
            $file_system_loader = new Twig_Loader_Filesystem();
            foreach ($settings['directories'] as $dir) {
                if (is_dir($dir)) {
                    $file_system_loader->addPath($dir);
                }
            }
            $loader->addLoader($file_system_loader);
        }

        return $loader;
    }

    /**
     * Twig Environment.
     * @return \Twig_Environment
     */
    public function getEnvironment()
    {
        /** @var Twig_LoaderInterface $loader */
        $loader = $this->getLoaders();
        $options = $this->container->get('settings')['views'] ?? [];

        return new Twig_Environment($loader, $options);
    }

    /**
     * Renders the template.
     *
     * @param array $context An array of parameters to pass to the template
     *
     * @return string The rendered template
     */
    public function render($name, $context = [])
    {
        $environment = $this->getEnvironment();
        return $environment->load($name)->render($context);
    }
}
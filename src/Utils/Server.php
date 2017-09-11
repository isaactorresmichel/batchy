<?php
namespace Batchy\Utils;

use Slim\App;
use Symfony\Component\Yaml\Yaml;

class Server
{
    /**
     * Parses the URL being requested returning TRUE on files or FALSE on non
     * files path-like requests.
     * @return bool
     */
    public static function parseCliRequest()
    {
        if (PHP_SAPI == 'cli-server') {
            // To help the built-in PHP dev server, check if the request was actually for
            // something which should probably be served as a static file
            $url = parse_url($_SERVER['REQUEST_URI']);
            $file = __DIR__ . $url['path'];
            if (is_file($file)) {
                return true;
            }
        }
        return false;
    }

    public static function parseRoutes(App $app, $file_path)
    {
        $routes = Yaml::parse(file_get_contents($file_path));
        foreach ($routes as $route) {
            $action = $route['action'];
            if (!is_array($action)) {
                $action = [$action];
            }
            $app->map($action, $route['path'], $route['controller']);
        }
    }

    public static function parseServices(App $app, $file_path)
    {
        $services = Yaml::parse(file_get_contents($file_path));
        $container = $app->getContainer();
        foreach ($services as $name => $info) {
            $container[$name] = new $info['class']($container);
        }
    }
}
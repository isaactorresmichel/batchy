<?php
namespace Batchy\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Route;

class CorsMiddleware
{
    public $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function allowCors(
        RequestInterface $request,
        ResponseInterface $response,
        $next
    ) {
        $route = $request->getAttribute("route");

        $methods = [];

        if (!empty($route)) {
            $pattern = $route->getPattern();

            /** @var Route $route */
            foreach ($this->container->router->getRoutes() as $route) {
                if ($pattern === $route->getPattern()) {
                    $methods = array_merge_recursive(
                        $methods,
                        $route->getMethods()
                    );
                }
            }
            //Methods holds all of the HTTP Verbs that a particular route handles.
        } else {
            $methods[] = $request->getMethod();
        }

        $response = $next($request, $response);


        return $response->withHeader(
            "Access-Control-Allow-Methods",
            implode(",", $methods)
        );
    }
}
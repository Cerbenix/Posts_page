<?php declare(strict_types=1);

namespace App;

use App\Views\View;
use DI\Container;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Router
{
    private array $routes;
    private Container $container;

    public function __construct(Container $container)
    {
        $this->routes = require_once 'routes.php';
        $this->container = $container;
    }

    public function response(): ?View
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $router) {
            foreach ($this->routes as $route) {
                [$httpMethod, $url, $handler] = $route;
                $router->addRoute($httpMethod, $url, $handler);
            }
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                header('Location: /error/404-NOT-FOUND');
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                header('Location: /error/405-ACCESS-DENIED');
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                [$controllerName, $methodName] = $handler;
                $controller = $this->container->get($controllerName);
                return $controller->{$methodName}($vars);
        }
        return null;
    }
}


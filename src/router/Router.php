<?php

namespace App\router;
use App\http\Redirect;
use App\http\Request;
use App\session\Session;

class Router
{
    public array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function __construct(
        public Request $request,
        public Session $session,
        public Redirect $redirect,
    ) {
        $this->initRoutes();
    }

    public function dispatch(string $method, string $uri)
    {
        $findRoute = $this->findRoute($method, $uri);

        if (! $findRoute) {
            $this->routeNotFound();
        }

        if (!$findRoute->hasMiddleware()) {
            [$middleware, $session, $redirect] = $findRoute->middleware($this->session, $this->redirect);

            $middleware = new $middleware[0]($session, $redirect);
            $middleware->check();
        }

        [$controller, $action] = $findRoute->action();

        $controller = new $controller($this->session, $this->request);
        echo call_user_func([$controller, $action]);
    }

    private function routeNotFound(): void
    {
        exit("404 | rout not found");
    }

    private function findRoute(string $method, string $uri): object|false
    {
        if (isset($this->routes[$method][$uri])){
            return $this->routes[$method][$uri];
        }
        return false;
    }

    private function initRoutes(): void
    {
        $routes = require_once APP_PATH . '/config/routes.php';

        foreach ($routes as $route) {
            if ($route->method() === 'GET') {
                $this->routes['GET'][$route->uri()] = $route;
            } elseif ($route->method() === 'POST') {
                $this->routes['POST'][$route->uri()] =$route;
            }
        }
    }
}
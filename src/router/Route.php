<?php


namespace App\router;


use App\http\Redirect;
use App\middleware\AuthMiddleware;
use App\session\Session;

class Route
{

    public function __construct(
        private string $method,
        private string $uri,
        private array $action,
        private array $middleware
    ) {
    }

    public static function get(string $uri, array $action, array $middleware = []): static
    {
        return new static('GET', $uri, $action, $middleware);
    }

    public static function post(string $uri, array $action, array $middleware = []): static
    {
        return new static('POST', $uri, $action, $middleware);
    }

    public function middleware(Session $session, Redirect $redirect): array
    {
        return [$this->middleware, $session, $redirect];
    }

    public function hasMiddleware(): bool
    {
        return empty($this->middleware);
    }

    /**
     * @return array
     */
    public function action(): array
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function uri(): string
    {
        return $this->uri;
    }
}
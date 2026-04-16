<?php

declare(strict_types=1);

namespace Core\Routing;

final class Router
{
    /** @var Route[] */
    private array $routes = [];

    private string $currentPrefix = '';

    public function __construct(
        private readonly ControllerFactory $factory,
        private readonly \Closure $notFoundHandler,
    ) {}

    public function group(string $prefix, callable $callback): void
    {
        $previousPrefix = $this->currentPrefix;
        $this->currentPrefix = $previousPrefix . $prefix;

        $callback($this);

        $this->currentPrefix = $previousPrefix;
    }

    public function get(string $uri, string $controller, string $action): static
    {
        return $this->addRoute('GET', $uri, $controller, $action);
    }

    public function post(string $uri, string $controller, string $action): static
    {
        return $this->addRoute('POST', $uri, $controller, $action);
    }

    public function put(string $uri, string $controller, string $action): static
    {
        return $this->addRoute('PUT', $uri, $controller, $action);
    }

    public function patch(string $uri, string $controller, string $action): static
    {
        return $this->addRoute('PATCH', $uri, $controller, $action);
    }

    public function delete(string $uri, string $controller, string $action): static
    {
        return $this->addRoute('DELETE', $uri, $controller, $action);
    }

    public function addRoute(string $method, string $uri, string $controller, string $action): static
    {
        $this->routes[] = new Route(
            strtoupper($method),
            $this->currentPrefix . $uri,
            $controller,
            $action,
        );

        return $this;
    }

    public function dispatch(string $requestUri, string $requestMethod): void
    {
        $uri = $this->normaliseUri($requestUri);
        $method = strtoupper($requestMethod);

        foreach ($this->routes as $route) {
            if ($route->method !== $method) {
                continue;
            }

            if (!$route->matches($uri)) {
                continue;
            }

            $controller = $this->factory->make($route->controller);
            $controller->{$route->action}(...$route->extractParams($uri));

            return;
        }

        ($this->notFoundHandler)();
    }

    private function normaliseUri(string $uri): string
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $path = is_string($path) ? $path : '/';
        return rtrim($path, '/') ?: '/';
    }
}

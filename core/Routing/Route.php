<?php

declare(strict_types=1);

namespace Core\Routing;

final class Route
{
    private readonly string $pattern;

    public function __construct(
        public readonly string $method,
        public readonly string $uri,
        public readonly string $controller,
        public readonly string $action,
    ) {
        $this->pattern = $this->compile($uri);
    }

    public function matches(string $uri): bool
    {
        return (bool) preg_match($this->pattern, $uri);
    }

    /** @return array<string, string> */
    public function extractParams(string $uri): array
    {
        preg_match($this->pattern, $uri, $matches);
        preg_match_all('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', $this->uri, $names);

        return array_intersect_key($matches, array_flip($names[1]));
    }

    private function compile(string $uri): string
    {
        $escaped = preg_quote($uri, '#');
        $pattern = preg_replace('/\\\{([a-zA-Z_][a-zA-Z0-9_]*)\\\}/', '(?P<$1>[^/]+)', $escaped);

        return '#^' . $pattern . '$#';
    }
}

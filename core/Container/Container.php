<?php

declare(strict_types=1);

namespace Core\Container;

use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;
use RuntimeException;

final class Container
{
    /** @var array<string, object> */
    private array $bindings = [];

    public function bind(string $type, object $instance): void
    {
        $this->bindings[$type] = $instance;
    }

    public function make(string $class): object
    {
        if (!class_exists($class)) {
            throw new RuntimeException("Container: class {$class} does not exist");
        }

        $constructor = (new ReflectionClass($class))->getConstructor();

        if ($constructor === null) {
            return new $class();
        }

        $args = array_map(
            fn(ReflectionParameter $param) => $this->resolve($param, $class),
            $constructor->getParameters(),
        );

        return new $class(...$args);
    }

    private function resolve(ReflectionParameter $param, string $class): mixed
    {
        $type = $param->getType();

        if ($type instanceof ReflectionNamedType) {
            $name = $type->getName();

            if (isset($this->bindings[$name])) {
                return $this->bindings[$name];
            }

            if (!$type->isBuiltin() && class_exists($name)) {
                return $this->make($name);
            }
        }

        if ($param->isOptional()) {
            return $param->getDefaultValue();
        }

        $typeName = $type instanceof ReflectionNamedType ? $type->getName() : 'unknown';

        throw new RuntimeException(
            "Container: cannot resolve \${$param->getName()} ({$typeName}) for {$class}"
        );
    }
}

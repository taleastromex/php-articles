<?php

declare(strict_types=1);

namespace Core\Routing;

final class ControllerFactory
{
    public function make(string $class): object
    {
        return new $class();
    }
}

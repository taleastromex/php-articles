<?php

declare(strict_types=1);

namespace Core\View;

interface ViewInterface
{
    /** @param array<string, mixed> $params */
    public function render(string $template, array $params = []): void;

    /** @param array<string, mixed> $params */
    public function renderToString(string $template, array $params = []): string;
}

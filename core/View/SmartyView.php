<?php

declare(strict_types=1);

namespace Core\View;

use Smarty;

final class SmartyView implements ViewInterface
{
    public function __construct(private readonly Smarty $smarty) {}

    /** @param array<string, mixed> $params */
    public function render(string $template, array $params = []): void
    {
        $this->smarty->assign($params);
        $this->smarty->display($template);
    }

    /** @param array<string, mixed> $params */
    public function renderToString(string $template, array $params = []): string
    {
        $this->smarty->assign($params);
        return $this->smarty->fetch($template);
    }
}

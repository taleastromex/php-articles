<?php

declare(strict_types=1);

namespace Core\View;

use Smarty;

final class SmartyFactory
{
    public function make(string $basePath): Smarty
    {
        $smarty = new Smarty();
        $smarty->setTemplateDir($basePath . '/views/templates');
        $smarty->setCompileDir($basePath . '/views/templates_c');
        $smarty->setCacheDir($basePath . '/views/cache');
        $smarty->setConfigDir($basePath . '/views/config');

        return $smarty;
    }
}

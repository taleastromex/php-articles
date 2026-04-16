<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\View\ViewInterface;

final class ErrorController
{
    public function __construct(private readonly ViewInterface $view) {}

    public function notFound(): void
    {
        http_response_code(404);
        $this->view->render('errors/404.tpl');
    }
}

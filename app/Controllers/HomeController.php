<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\View\ViewInterface;

final class IndexController
{
    public function __construct(private readonly ViewInterface $view) {}

    public function index(): void
    {
        $this->view->render('index.tpl', ['name' => 'world']);
    }
}

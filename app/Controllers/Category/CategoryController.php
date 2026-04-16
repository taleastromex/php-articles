<?php

namespace App\Controllers\Category;

use Core\View\ViewInterface;

final class CategoryController
{
    public function __construct(private readonly ViewInterface $view) {}

    public function index(): void
    {
        $this->view->render('category/index.tpl');
    }
}
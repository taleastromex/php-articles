<?php

namespace App\Controllers\Article;

use Core\View\ViewInterface;

class ArticleController
{
    public function __construct(private readonly ViewInterface $view) {}

    public function index(): void
    {
        $this->view->render('article/index.tpl');
    }
}
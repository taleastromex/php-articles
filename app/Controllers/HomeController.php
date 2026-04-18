<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use Core\View\ViewInterface;

final class HomeController
{
    public function __construct(
        private readonly ViewInterface $view,
        private readonly ArticleRepository $articleRepository,
        private readonly CategoryRepository $categoryRepository,
    ) {}

    public function index(): void
    {
        $categories = $this->categoryRepository->findAll();
        $groupedArticles = $this->articleRepository->findLatestGroupedByCategory();

        $categoriesById = [];
        foreach ($categories as $category) {
            $categoriesById[$category->id] = $category;
        }

        $this->view->render('home/index.tpl', ['categoriesById' => $categoriesById, 'groupedArticles' => $groupedArticles]);
    }
}

<?php

namespace App\Controllers\Article;

use App\Entities\Category;
use App\Repositories\ArticleRepository;
use Core\View\ViewInterface;

class ArticleController
{
    public function __construct(
        private readonly ViewInterface $view,
        private readonly ArticleRepository $articleRepository,
    ) {}

    public function show(string $slug): void
    {
        $article = $this->articleRepository->findBySlug($slug);

        $similar = $this->articleRepository->findSimilar(
            $article->id,
            array_map(fn (Category $category) => $category->id, $article->categories)
        );

        $this->view->render('article/show.tpl', ['article' => $article, 'similar' => $similar]);
    }
}
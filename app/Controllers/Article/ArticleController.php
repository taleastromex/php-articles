<?php

declare(strict_types=1);

namespace App\Controllers\Article;

use App\Entities\Category;
use App\Repositories\ArticleRepository;
use App\Services\ViewTracker;
use Core\Http\Exceptions\NotFoundException;
use Core\View\ViewInterface;

final class ArticleController
{
    public function __construct(
        private readonly ViewInterface $view,
        private readonly ArticleRepository $articleRepository,
        private readonly ViewTracker $viewTracker,
    ) {}

    public function show(string $slug): void
    {
        $article = $this->articleRepository->findBySlug($slug);

        if (!$article) {
            throw new NotFoundException("Article '{$slug}' not found");
        }

        $this->viewTracker->track($article->id);

        $similar = $this->articleRepository->findSimilar(
            excludeId: $article->id,
            categoryIds: array_map(fn(Category $c) => $c->id, $article->categories),
        );

        $this->view->render('article/show.tpl', [
            'article' => $article,
            'similar' => $similar,
        ]);
    }
}
<?php

declare(strict_types=1);

namespace App\Controllers\Category;

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use Core\Database\Paginator;
use Core\Http\Exceptions\NotFoundException;
use Core\View\ViewInterface;

final class CategoryController
{
    public function __construct(
        private readonly ViewInterface $view,
        private readonly CategoryRepository $categoryRepository,
        private readonly ArticleRepository $articleRepository,
    ) {}

    public function show(string $slug): void
    {
        $category = $this->categoryRepository->findBySlug($slug);

        if (!$category) {
            throw new NotFoundException("Category '{$slug}' not found");
        }

        $sort  = $_GET['sort']  ?? 'created_at';
        $order = $_GET['order'] ?? 'desc';

        $paginator = Paginator::fromRequest(
            total: $this->articleRepository->countByCategory($category->id),
            perPage: 10,
            page: (int) ($_GET['page'] ?? 1),
        );

        $articles = $this->articleRepository->findByCategory(
            categoryId: $category->id,
            limit: $paginator->perPage,
            offset: $paginator->offset,
            sort: $sort,
            order: $order,
        );

        $this->view->render('category/show.tpl', [
            'category' => $category,
            'articles' => $articles,
            'paginator' => $paginator,
            'sort' => $sort,
            'order' => $order,
        ]);
    }
}
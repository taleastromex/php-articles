<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Article;
use App\Entities\ArticlePreview;
use App\Entities\Category;
use Core\Database\AbstractRepository;

final class ArticleRepository extends AbstractRepository
{
    private const ALLOWED_SORTS = ['created_at', 'views'];
    private const ALLOWED_ORDERS = ['asc', 'desc'];

    /**
     * Home page: latest N articles per category in a single query.
     * Uses ROW_NUMBER() window function to pick top-N within each group.
     *
     * @return array<int, ArticlePreview[]>
     */
    public function findLatestGroupedByCategory(int $limit = 3): array
    {
        $rows = $this->fetchAll(
            'SELECT id, title, slug, description, image, views, created_at, category_id
             FROM (
                 SELECT
                     a.id, a.title, a.slug, a.description,
                     a.image, a.views, a.created_at,
                     ac.category_id,
                     ROW_NUMBER() OVER (
                         PARTITION BY ac.category_id
                         ORDER BY a.created_at DESC
                     ) AS row_num
                 FROM articles a
                 JOIN article_category ac ON ac.article_id = a.id
             ) ranked
             WHERE row_num <= :limit
             ORDER BY category_id, created_at DESC',
            ['limit' => $limit],
        );

        $ids = array_map(fn(array $r) => (int)$r['id'], $rows);
        $catsByArticle = $this->fetchCategoriesForArticles($ids);

        $grouped = [];
        foreach ($rows as $row) {
            $categoryId = (int)$row['category_id'];
            $grouped[$categoryId][] = $this->hydratePreview($row, $catsByArticle[(int)$row['id']] ?? []);
        }

        return $grouped;
    }

    /**
     * @return ArticlePreview[]
     */
    public function findByCategory(
        int $categoryId,
        int $limit,
        int $offset,
        string $sort = 'created_at',
        string $order = 'desc',
    ): array
    {
        $sort = in_array($sort, self::ALLOWED_SORTS, true) ? $sort : 'created_at';
        $order = in_array($order, self::ALLOWED_ORDERS, true) ? $order : 'desc';

        $rows = $this->fetchAll(
            "SELECT a.id, a.title, a.slug, a.description, a.image, a.views, a.created_at
             FROM articles a
             JOIN article_category ac ON ac.article_id = a.id
             WHERE ac.category_id = :category_id
             ORDER BY a.{$sort} {$order}
             LIMIT :limit OFFSET :offset",
            ['category_id' => $categoryId, 'limit' => $limit, 'offset' => $offset],
        );

        $ids = array_map(fn(array $r) => (int)$r['id'], $rows);
        $catsByArticle = $this->fetchCategoriesForArticles($ids);

        return array_map(
            fn(array $row) => $this->hydratePreview($row, $catsByArticle[(int)$row['id']] ?? []),
            $rows,
        );
    }

    public function countByCategory(int $categoryId): int
    {
        return $this->count(
            'SELECT COUNT(*)
             FROM articles a
             JOIN article_category ac ON ac.article_id = a.id
             WHERE ac.category_id = :category_id',
            ['category_id' => $categoryId],
        );
    }

    public function findBySlug(string $slug): ?Article
    {
        $row = $this->fetchOne(
            'SELECT id, title, slug, description, content, image, views, created_at
             FROM articles
             WHERE slug = :slug
             LIMIT 1',
            ['slug' => $slug],
        );

        if ($row === null) {
            return null;
        }

        $categories = $this->fetchCategoriesForArticles([(int)$row['id']]);

        return $this->hydrate($row, $categories[(int)$row['id']] ?? []);
    }

    /**
     * @param int[] $categoryIds
     * @return ArticlePreview[]
     */
    public function findSimilar(int $excludeId, array $categoryIds, int $limit = 3): array
    {
        if (empty($categoryIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));

        $rows = $this->fetchAll(
            "SELECT DISTINCT a.id, a.title, a.slug, a.description, a.image, a.views, a.created_at
             FROM articles a
             JOIN article_category ac ON ac.article_id = a.id
             WHERE ac.category_id IN ({$placeholders})
               AND a.id != ?
             ORDER BY a.created_at DESC
             LIMIT ?",
            [...$categoryIds, $excludeId, $limit],
        );

        $ids = array_map(fn(array $r) => (int)$r['id'], $rows);
        $catsByArticle = $this->fetchCategoriesForArticles($ids);

        return array_map(
            fn(array $row) => $this->hydratePreview($row, $catsByArticle[(int)$row['id']] ?? []),
            $rows,
        );
    }

    public function create(
        string $title,
        string $slug,
        string $description,
        string $content,
        ?string $image = null,
    ): int
    {
        $this->execute(
            'INSERT INTO articles (title, slug, description, content, image)
             VALUES (:title, :slug, :description, :content, :image)',
            [
                'title' => $title,
                'slug' => $slug,
                'description' => $description,
                'content' => $content,
                'image' => $image,
            ],
        );

        return $this->lastInsertId();
    }

    public function attachCategory(int $articleId, int $categoryId): void
    {
        $this->execute(
            'INSERT IGNORE INTO article_category (article_id, category_id) VALUES (:article_id, :category_id)',
            ['article_id' => $articleId, 'category_id' => $categoryId],
        );
    }

    public function incrementViews(int $id): void
    {
        $this->execute(
            'UPDATE articles SET views = views + 1 WHERE id = :id',
            ['id' => $id],
        );
    }

    /**
     * Bulk-fetch categories for multiple articles at once (avoids N+1).
     *
     * @param int[] $articleIds
     * @return array<int, Category[]>
     */
    private function fetchCategoriesForArticles(array $articleIds): array
    {
        if (empty($articleIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($articleIds), '?'));

        $rows = $this->fetchAll(
            "SELECT ac.article_id, c.id, c.name, c.slug, c.description
             FROM categories c
             JOIN article_category ac ON ac.category_id = c.id
             WHERE ac.article_id IN ({$placeholders})",
            $articleIds,
        );

        $result = [];
        foreach ($rows as $row) {
            $articleId = (int) $row['article_id'];
            $result[$articleId][] = new Category(
                id: (int) $row['id'],
                name: (string) $row['name'],
                slug: (string) $row['slug'],
                description: isset($row['description']) ? (string) $row['description'] : null,
            );
        }

        return $result;
    }

    /**
     * @param array<string, mixed> $row
     * @param Category[] $categories
     */
    private function hydrate(array $row, array $categories = []): Article
    {
        return new Article(
            id: (int) $row['id'],
            title: (string) $row['title'],
            slug: (string) $row['slug'],
            description: (string) $row['description'],
            content: (string) $row['content'],
            image: isset($row['image']) ? (string) $row['image'] : null,
            views: (int) $row['views'],
            createdAt: (string) $row['created_at'],
            categories: $categories,
        );
    }

    /**
     * @param array<string, mixed> $row
     * @param Category[] $categories
     */
    private function hydratePreview(array $row, array $categories = []): ArticlePreview
    {
        return new ArticlePreview(
            id: (int)$row['id'],
            title: (string)$row['title'],
            slug: (string)$row['slug'],
            description: (string)$row['description'],
            image: isset($row['image']) ? (string)$row['image'] : null,
            views: (int)$row['views'],
            createdAt: (string)$row['created_at'],
            categories: $categories,
        );
    }
}

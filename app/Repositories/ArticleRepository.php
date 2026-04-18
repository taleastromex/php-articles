<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Article;
use App\Entities\Category;
use Core\Database\AbstractRepository;

final class ArticleRepository extends AbstractRepository
{
    private const ALLOWED_SORTS = ['created_at', 'views'];

    /**
     * @return Article[]
     */
    public function findLatestByCategory(int $categoryId, int $limit = 3): array
    {
        $rows = $this->fetchAll(
            'SELECT a.id, a.title, a.slug, a.description, a.content, a.image, a.views, a.created_at
             FROM articles a
             JOIN article_category ac ON ac.article_id = a.id
             WHERE ac.category_id = :category_id
             ORDER BY a.created_at DESC
             LIMIT :limit',
            ['category_id' => $categoryId, 'limit' => $limit],
        );

        return array_map(fn(array $row) => $this->hydrate($row), $rows);
    }

    /**
     * @return Article[]
     */
    public function findByCategory(int $categoryId, int $limit, int $offset, string $sort = 'created_at'): array
    {
        $sort = in_array($sort, self::ALLOWED_SORTS, true) ? $sort : 'created_at';

        $rows = $this->fetchAll(
            "SELECT a.id, a.title, a.slug, a.description, a.content, a.image, a.views, a.created_at
             FROM articles a
             JOIN article_category ac ON ac.article_id = a.id
             WHERE ac.category_id = :category_id
             ORDER BY a.{$sort} DESC
             LIMIT :limit OFFSET :offset",
            ['category_id' => $categoryId, 'limit' => $limit, 'offset' => $offset],
        );

        return array_map(fn(array $row) => $this->hydrate($row), $rows);
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

        $categories = $this->fetchCategories((int)$row['id']);

        return $this->hydrate($row, $categories);
    }

    /**
     * @param int[] $categoryIds
     * @return Article[]
     */
    public function findSimilar(int $excludeId, array $categoryIds, int $limit = 3): array
    {
        if (empty($categoryIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));

        $rows = $this->fetchAll(
            "SELECT DISTINCT a.id, a.title, a.slug, a.description, a.content, a.image, a.views, a.created_at
             FROM articles a
             JOIN article_category ac ON ac.article_id = a.id
             WHERE ac.category_id IN ({$placeholders})
               AND a.id != ?
             ORDER BY a.created_at DESC
             LIMIT ?",
            [...$categoryIds, $excludeId, $limit],
        );

        return array_map(fn(array $row) => $this->hydrate($row), $rows);
    }

    public function create(
        string  $title,
        string  $slug,
        string  $description,
        string  $content,
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

    /**
     * TODO: take into account pseudo-unique article views by cookie
     */
    public function incrementViews(int $id): void
    {
        $this->execute(
            'UPDATE articles SET views = views + 1 WHERE id = :id',
            ['id' => $id],
        );
    }

    /**
     * @return Category[]
     */
    private function fetchCategories(int $articleId): array
    {
        $rows = $this->fetchAll(
            'SELECT c.id, c.name, c.slug, c.description
             FROM categories c
             JOIN article_category ac ON ac.category_id = c.id
             WHERE ac.article_id = :article_id',
            ['article_id' => $articleId],
        );

        return array_map(
            fn(array $row) => new Category(
                id: (int)$row['id'],
                name: (string)$row['name'],
                slug: (string)$row['slug'],
                description: isset($row['description']) ? (string)$row['description'] : null,
            ),
            $rows,
        );
    }

    /**
     * @param array<string, mixed> $row
     * @param Category[] $categories
     */
    private function hydrate(array $row, array $categories = []): Article
    {
        return new Article(
            id: (int)$row['id'],
            title: (string)$row['title'],
            slug: (string)$row['slug'],
            description: (string)$row['description'],
            content: (string)$row['content'],
            image: isset($row['image']) ? (string)$row['image'] : null,
            views: (int)$row['views'],
            createdAt: (string)$row['created_at'],
            categories: $categories,
        );
    }
}

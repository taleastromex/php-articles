<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Category;
use Core\Database\AbstractRepository;

final class CategoryRepository extends AbstractRepository
{
    /** @return Category[] */
    public function findAll(): array
    {
        $rows = $this->fetchAll('SELECT id, name, slug, description FROM categories ORDER BY name');

        return array_map(fn(array $row) => $this->hydrate($row), $rows);
    }

    public function findById(int $id): ?Category
    {
        $row = $this->fetchOne('SELECT id, name, slug, description FROM categories WHERE id = :id LIMIT 1', ['id' => $id]);

        return $row !== null ? $this->hydrate($row) : null;
    }

    public function findBySlug(string $slug): ?Category
    {
        $row = $this->fetchOne('SELECT id, name, slug, description FROM categories WHERE slug = :slug LIMIT 1', ['slug' => $slug]);

        return $row !== null ? $this->hydrate($row) : null;
    }

    public function create(string $name, string $slug, ?string $description = null): Category
    {
        $this->execute(
            'INSERT INTO categories (name, slug, description) VALUES (:name, :slug, :description)',
            ['name' => $name, 'slug' => $slug, 'description' => $description],
        );

        return new Category(
            id: $this->lastInsertId(),
            name: $name,
            slug: $slug,
            description: $description,
        );
    }

    public function delete(int $id): void
    {
        $this->execute('DELETE FROM categories WHERE id = :id', ['id' => $id]);
    }

    /** @param array<string, mixed> $row */
    private function hydrate(array $row): Category
    {
        return new Category(
            id: (int) $row['id'],
            name: (string) $row['name'],
            slug: (string) $row['slug'],
            description: isset($row['description']) ? (string) $row['description'] : null,
        );
    }
}

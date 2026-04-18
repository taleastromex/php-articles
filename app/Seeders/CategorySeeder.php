<?php

declare(strict_types=1);

namespace App\Seeders;

use App\Entities\Category;
use App\Repositories\CategoryRepository;

final class CategorySeeder
{
    public function __construct(private readonly CategoryRepository $categories) {}

    /**
     * @return Category[]
     */
    public function run(): array
    {
        $data = [
            ['name' => 'PHP', 'slug' => 'php', 'description' => 'Статьи о языке программирования PHP: синтаксис, паттерны, best practices.'],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'description' => 'Всё о JavaScript: от основ до современных фреймворков.'],
            ['name' => 'Docker', 'slug' => 'docker', 'description' => 'Контейнеризация, docker-compose, деплой и оркестрация.'],
            ['name' => 'Базы данных', 'slug' => 'databases', 'description' => 'MySQL, PostgreSQL, Redis — проектирование и оптимизация.'],
            ['name' => 'Архитектура', 'slug' => 'architecture', 'description' => 'SOLID, паттерны проектирования, чистая архитектура.'],
        ];

        $created = [];

        foreach ($data as $item) {
            $created[] = $this->categories->create(
                name: $item['name'],
                slug: $item['slug'],
                description: $item['description'],
            );
        }

        echo 'Categories seeded: ' . count($created) . PHP_EOL;

        return $created;
    }
}

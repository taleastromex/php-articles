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
            ['name' => 'PHP', 'slug' => 'php', 'description' => 'Articles about PHP: syntax, design patterns, and best practices.'],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'description' => 'Everything about JavaScript: from the basics to modern frameworks.'],
            ['name' => 'Docker', 'slug' => 'docker', 'description' => 'Containerisation, docker-compose, deployment and orchestration.'],
            ['name' => 'Databases', 'slug' => 'databases', 'description' => 'MySQL, PostgreSQL, Redis — schema design and query optimisation.'],
            ['name' => 'Architecture', 'slug' => 'architecture', 'description' => 'SOLID, design patterns, and clean architecture.'],
            ['name' => 'Python', 'slug' => 'python', 'description' => 'Python fundamentals, data processing, scripting, and ecosystem tools.'],
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

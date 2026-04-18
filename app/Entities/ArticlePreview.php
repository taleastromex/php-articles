<?php

declare(strict_types=1);

namespace App\Entities;

final class ArticlePreview
{
    /** @param Category[] $categories */
    public function __construct(
        public readonly int     $id,
        public readonly string  $title,
        public readonly string  $slug,
        public readonly string  $description,
        public readonly ?string $image,
        public readonly int     $views,
        public readonly string  $createdAt,
        public readonly array   $categories = [],
    ) {}
}

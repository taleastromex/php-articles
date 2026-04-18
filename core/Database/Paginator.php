<?php

declare(strict_types=1);

namespace Core\Database;

final class Paginator
{
    public readonly int $totalPages;
    public readonly int $offset;

    public function __construct(
        public readonly int $total,
        public readonly int $currentPage,
        public readonly int $perPage,
    ) {
        $this->totalPages = (int)ceil($total / $perPage);
        $this->offset = ($currentPage - 1) * $perPage;
    }

    public static function fromRequest(int $total, int $perPage, int $page): self
    {
        $totalPages = max(1, (int)ceil($total / $perPage));
        $currentPage = max(1, min($page, $totalPages));

        return new self(
            total: $total,
            currentPage: $currentPage,
            perPage: $perPage,
        );
    }

    public function hasPages(): bool
    {
        return $this->totalPages > 1;
    }

    public function hasPrev(): bool
    {
        return $this->currentPage > 1;
    }

    public function hasNext(): bool
    {
        return $this->currentPage < $this->totalPages;
    }
}

<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\ArticleRepository;

final class ViewTracker
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
    ) {}

    public function track(int $articleId): void
    {
        $cookieName = 'viewed_articles';
        $viewed = array_filter(explode(',', $_COOKIE[$cookieName] ?? ''));

        if (!in_array((string) $articleId, $viewed, true)) {
            $this->articleRepository->incrementViews($articleId);
            $viewed[] = (string) $articleId;
            setcookie($cookieName, implode(',', $viewed), time() + 60 * 60 * 24 * 30, '/');
        }
    }
}
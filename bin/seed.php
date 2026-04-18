<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Seeders\ArticleSeeder;
use App\Seeders\CategorySeeder;
use Core\Database\Connection;
use Core\Database\DatabaseConfig;

$db = new Connection(new DatabaseConfig(
    host: (string)(getenv('DB_HOST') ?: 'mysql'),
    port: (int)(getenv('DB_PORT') ?: 3306),
    database: (string)(getenv('DB_DATABASE') ?: 'articles'),
    username: (string)(getenv('DB_USERNAME') ?: 'articles_user'),
    password: (string)(getenv('DB_PASSWORD') ?: 'secret'),
));

try {
    if (in_array('--fresh', $argv ?? [], true)) {
        $pdo = $db->pdo();
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
        $pdo->exec('TRUNCATE TABLE article_category');
        $pdo->exec('TRUNCATE TABLE articles');
        $pdo->exec('TRUNCATE TABLE categories');
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

        echo "\033[32mTables truncated.\033[32m" . PHP_EOL;
    }

    $categoryRepository = new CategoryRepository($db);
    $articleRepository  = new ArticleRepository($db);

    $categories = (new CategorySeeder($categoryRepository))->run();
    (new ArticleSeeder($articleRepository))->run($categories);

    echo "\033[32mDone.\033[32m" . PHP_EOL;
} catch (\PDOException $e) {
    echo "\033[31mDatabase Error: " . $e->getMessage() . "\033[0m" . PHP_EOL;
} catch (\Throwable $e) {
    echo "\033[31mError: " . $e->getMessage() . "\033[0m" . PHP_EOL;
}

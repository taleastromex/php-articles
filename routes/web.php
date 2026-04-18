<?php

/**
 * @var Core\Routing\Router $router
 */

use App\Controllers\Article\ArticleController;
use App\Controllers\Category\CategoryController;
use App\Controllers\HomeController;

$router->get('/', HomeController::class, 'index');
$router->get('/categories', CategoryController::class, 'index');
$router->get('/articles', ArticleController::class, 'index');
$router->get('/articles/{slug}', ArticleController::class, 'show');

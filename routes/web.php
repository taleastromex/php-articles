<?php

/**
 * @var Core\Routing\Router $router
 */

use App\Controllers\Article\ArticleController;
use App\Controllers\Category\CategoryController;
use App\Controllers\IndexController;

$router->get('/', IndexController::class, 'index');
$router->get('/categories', CategoryController::class, 'index');
$router->get('/articles', ArticleController::class, 'index');

<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ErrorController;
use Core\Http\JsonResponse;
use Core\Container\Container;
use Core\Routing\Router;
use Core\View\SmartyFactory;
use Core\View\SmartyView;
use Core\View\ViewInterface;

$view = new SmartyView((new SmartyFactory())->make(dirname(__DIR__)));

$container = new Container();
$container->bind(ViewInterface::class, $view);
$container->bind(JsonResponse::class, new JsonResponse());

$router = new Router(
    $container,
    static fn() => (new ErrorController($view))->notFound(),
);

require __DIR__ . '/../routes/web.php';

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

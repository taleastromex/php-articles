<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ErrorController;
use Core\Database\Connection;
use Core\Database\DatabaseConfig;
use Core\Http\JsonResponse;
use Core\Container\Container;
use Core\Routing\Router;
use Core\View\SmartyFactory;
use Core\View\SmartyView;
use Core\View\ViewInterface;

$view = new SmartyView((new SmartyFactory())->make(dirname(__DIR__)));

$db = new Connection(new DatabaseConfig(
    host: (string) getenv('DB_HOST'),
    port: (int) (getenv('DB_PORT') ?: 3306),
    database: (string) getenv('DB_DATABASE'),
    username: (string) getenv('DB_USERNAME'),
    password: (string) getenv('DB_PASSWORD'),
));

$container = new Container();
$container->bind(ViewInterface::class, $view);
$container->bind(JsonResponse::class, new JsonResponse());
$container->bind(Connection::class, $db);

$router = new Router(
    $container,
    static fn() => (new ErrorController($view))->notFound(),
);

require __DIR__ . '/../routes/web.php';

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

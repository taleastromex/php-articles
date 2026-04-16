<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ErrorController;
use Core\Routing\ControllerFactory;
use Core\Routing\Router;

$router = new Router(
    new ControllerFactory(),
    static fn() => (new ErrorController())->notFound(),
);

require __DIR__ . '/../routes/web.php';

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

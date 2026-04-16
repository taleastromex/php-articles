<?php

declare(strict_types=1);

namespace App\Controllers;

class ErrorController
{
    public function notFound(): void
    {
        http_response_code(404);
        echo "<h1>Page not found</h1>";
    }
}
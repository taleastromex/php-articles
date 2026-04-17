<?php

declare(strict_types=1);

namespace Core\Database;

use PDO;

final class Connection
{
    private ?PDO $pdo = null;

    public function __construct(private readonly DatabaseConfig $config) {}

    public function pdo(): PDO
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO(
                $this->config->dsn(),
                $this->config->username,
                $this->config->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ],
            );
        }

        return $this->pdo;
    }
}

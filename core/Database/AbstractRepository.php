<?php

declare(strict_types=1);

namespace Core\Database;

abstract class AbstractRepository
{
    public function __construct(protected readonly Connection $db) {}

    /**
     * @param array<string, mixed> $params
     * @return array<string, mixed>|null
     */
    protected function fetchOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->db->pdo()->prepare($sql);
        $stmt->execute($params);

        $row = $stmt->fetch();

        return $row !== false ? $row : null;
    }

    /**
     * @param array<string, mixed> $params
     * @return array<int, array<string, mixed>>
     */
    protected function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->db->pdo()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /**
     * @param array<string, mixed> $params
     */
    protected function execute(string $sql, array $params = []): void
    {
        $this->db->pdo()->prepare($sql)->execute($params);
    }

    /**
     * @param array<string, mixed> $params
     */
    protected function count(string $sql, array $params = []): int
    {
        $stmt = $this->db->pdo()->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn();
    }

    protected function lastInsertId(): int
    {
        return (int) $this->db->pdo()->lastInsertId();
    }
}

<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

class ArticleRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function findPublished(int $page): array
    {
        return $this->connection->fetchAllAssociative(
            'SELECT id, title, summary FROM articles WHERE published = 1 ORDER BY id DESC LIMIT 20 OFFSET ?',
            [($page - 1) * 20]
        );
    }

    public function searchByTitle(string $query): array
    {
        $sql = "SELECT id, title, summary FROM articles WHERE title LIKE '%" . $query . "%'";

        return $this->connection->fetchAllAssociative($sql);
    }
}

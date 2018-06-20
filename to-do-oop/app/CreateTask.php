<?php

declare(strict_types=1);

namespace Todo;

use PDO;
use PDOException;
use Todo\Exception\TaskException;

class CreateTask
{
    private $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function create(string $title, string $due, string $author, string $desription) : void
    {
        try {
            $insert = "INSERT INTO tasks (title, due, author, description) VALUES (:title, :due, :author, :description)";
            $stmt = $this->db
                        ->prepare($insert);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':due', $due);
            $stmt->bindParam(':author', $author);
            $stmt->bindParam(':description', $description);
            $stmt->execute();
        } catch (PDOException $exception) {
            throw TaskException::forCreateTaskError($exception->getMessage());
        }
    }
}
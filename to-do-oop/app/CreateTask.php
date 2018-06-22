<?php

declare(strict_types=1);

namespace Todo;

use PDO;
use PDOException;
use Todo\Exception\TaskException;
use Todo\Task;

class CreateTask
{
    private $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function create(Task $task) : void
    {
        try {
            $insert = "INSERT INTO tasks (title, due, author, description) VALUES (:title, :due, :author, :description)";
            $stmt = $this->db
                        ->prepare($insert);
                        
            $stmt->bindValue(':title', $task->title());
            $stmt->bindValue(':due', $task->due()->format('Y-m-d'));
            $stmt->bindValue(':author', $task->author());
            $stmt->bindValue(':description', $task->description());
            $stmt->execute();
        } catch (PDOException $exception) {
            throw TaskException::forCreateTaskError($exception->getMessage());
        }
    }
}
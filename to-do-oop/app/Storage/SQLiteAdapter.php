<?php

declare(strict_types=1);

namespace Todo\Storage;

use PDO;
use DateTime;
use Todo\Storage\TaskStorageAdapterInterface;
use Todo\Task;
use Todo\Exception\TaskNotFoundException;

class SQLiteAdapter implements TaskStorageAdapterInterface
{
    /** @var PDO $db */
    private $db;

    public function __construct()
    {
        $connection = new PDO('sqlite:todo.sqlite');
        $connection->setAttribute(
            PDO::ATTR_ERRMODE, 
            PDO::ERRMODE_EXCEPTION
        );

        $this->db = $connection;
    }

    public function lastInsertId() : int
    {
        return (int) $this->db
                    ->lastInsertId();
    }

    public function getAll() : array
    {
        $query = "SELECT * FROM tasks";
        $result = $this->db
                        ->query($query)
                        ->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function find(int $task_id) : Task
    {
        $query = "SELECT * from tasks WHERE id = $task_id";
        $result = $this->db
                        ->query($query)
                        ->fetch();
        if (!$result) {
            throw TaskNotFoundException::notFound($task_id);
        }

        $task = Task::create($result['cpf'], $result['description'], new DateTime($result['due']), $result['author']);

        return $task;
    }

    public function persist(Task $task) : Task
    {
        $insert = "INSERT INTO tasks (cpf, description, due, author) VALUES (:cpf, :description, :due, :author)";
        $stmt = $this->db
                    ->prepare($insert);
                    
        $stmt->bindValue(':cpf', $task->cpf());
        $stmt->bindValue(':description', $task->description());
        $stmt->bindValue(':due', $task->due()->format('Y-m-d'));
        $stmt->bindValue(':author', $task->author());
        $stmt->execute();

        return $task;
    }
}
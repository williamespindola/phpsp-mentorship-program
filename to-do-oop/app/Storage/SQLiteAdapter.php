<?php

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
        return $this->db
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

        $task = Task::create($result['title'], new DateTime($result['due']), $result['author'], $result['description']);

        return $task;
    }

    public function persist(Task $task) : Task
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

            return $task;
        } catch (\PDOException $exception) {
            return $exception->getMessage();
        }
    }
}
<?php

namespace Todo;

class CreateTask
{
    private $db;

    public function __construct(\PDO $pdo)
    {
        $pdo->setAttribute(
            \PDO::ATTR_ERRMODE, 
            \PDO::ERRMODE_EXCEPTION
        );
        $this->db = $pdo;
        
    }

    public function create(string $title, string $due, string $author, string $desription = null)
    {
        try {
            // $db = new \PDO('sqlite:todo.sqlite');
            $insert = "INSERT INTO tasks (title, due, author, description) VALUES (:title, :due, :author, :description)";
            $stmt = $this->db
                        ->prepare($insert);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':due', $due);
            $stmt->bindParam(':author', $author);
            $stmt->bindParam(':description', $description);
            $stmt->execute();

            return "Task successfully created.";
        } catch (\PDOException $exception) {
            return "Unable to create Task, error: " . $exception->getMessage();
        }
    }
}
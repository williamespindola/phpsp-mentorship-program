<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use DateTime;
use PDO;
use Todo\Task;
use Todo\CreateTask;

class CreateTaskTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateTaskSuccessfully()
    {
        $task = new Task('lol', new DateTime('01-01-2018'), 'josé filho', 'uma descrição foda');
        $pdo = new PDO('sqlite:todo.sqlite');
        $createTask = new CreateTask($pdo);
        $createTask->create($task);

        $createdTask = $pdo->query("SELECT * FROM tasks WHERE title = 'lol'")
                            ->fetchObject();
        
        $this->assertEquals('lol', $createdTask->title);
    }
}
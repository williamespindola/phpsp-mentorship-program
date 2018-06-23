<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use DateTime;
use Todo\Storage\SQLiteAdapter;
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
        $connection = new SQLiteAdapter();
        $createTask = new CreateTask($connection);
        $createTask->create($task);

        $createdTask = $connection->find($connection->lastInsertId());
        
        $this->assertEquals('lol', $createdTask->title());
    }
}
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
        $mock = $this->createMock(CreateTask::class);

        $mock->expects($this->once())
                        ->method('create')
                        ->willReturn($task);
        
        $createTaskMock = $mock->create($task);

        $this->assertEquals($task, $createTaskMock);
        $this->assertEquals($task->title(), $createTaskMock->title());
    }
}
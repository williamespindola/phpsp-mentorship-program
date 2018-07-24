<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use DateTime;
use Todo\Storage\TaskStorageAdapterInterface;
use Todo\Task;
use Todo\CreateTask;
// use Todo\Exception\TaskException;

class CreateTaskTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateTaskSuccessfully()
    {
        $task = new Task('lol', new DateTime('01-01-2018'), 'josé filho', 'uma descrição foda');

        $storage = $this->createMock(TaskStorageAdapterInterface::class);
        $storage->expects($this->once())
                ->method('persist')
                ->willReturn($task)
                ->with($this->equalTo($task));
                
        
        $createTask = new CreateTask($storage);
        $createdTask = $createTask->create($task);

        $this->assertEquals($task, $createdTask);
    }

    /**
     * @test
     * @expectedException \Todo\Exception\TaskException
     */
    public function shouldThrowTaskExceptionWhenAdapterFails()
    {
        $task = new Task('lol', new DateTime('01-01-2018'), 'josé filho', 'uma descrição foda');

        $storage = $this->createMock(TaskStorageAdapterInterface::class);
        $storage->expects($this->once())
                ->method('persist')
                ->will($this->throwException(new \Todo\Exception\TaskException('Um erro cabuloso!')))
                ->with($this->equalTo($task));

        $createTask = new CreateTask($storage);
        $createTask->create($task);
    }
}
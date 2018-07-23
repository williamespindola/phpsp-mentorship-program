<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use DateTime;
use PDO;
use PDOStatement;
use Todo\Task;
use Todo\CreateTask;

class CreateTaskTest extends TestCase
{
    public function testShouldCreateTaskSuccessfully()
    {
        $dummyTask = $this->createMock(Task::class);

        $dummyTask->method('title')->willReturn('title');
        $dummyTask->method('due')->willReturn(new \DateTime('2018-10-10'));
        $dummyTask->method('author')->willReturn('author');
        $dummyTask->method('description')->willReturn('description');

        $dummyStatement = $this->createMock(PDOStatement::class)
            ->setMethods(['bindValue', 'execute'])
            ->disableOriginalContstructor()
            ->getMock();

        $dummyConnection = $this->getMockBuilder(PDO::class)
            ->setMethods(['prepare'])
            ->disableOriginalContstructor()
            ->getMock();

        $dummyConnection->expects($this->any())
            ->method('prepare')
            ->willReturn($dummyStatement);

        $dummyStatement->expects($spy = $this->any())
            ->method('execute')
            ->willReturn($dummyStatement);

        $createTask = new CreateTask($connection);

        $createTask->create($dummyTask);

        $this->assertCount(1, $spy->getInvocations());
    }
}
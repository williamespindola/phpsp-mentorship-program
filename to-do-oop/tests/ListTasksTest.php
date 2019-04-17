<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use DateTime;
use Todo\Storage\TaskStorageAdapterInterface;
use Todo\Task;
use Todo\ListTasks;
use Todo\CreateTask;
use Todo\Storage\SQLiteAdapter;

class ListTasksTest extends TestCase
{
    private function prepareListOfTasks()
    {
        $task1 = ['cpf' => '11.222.333.04', 'description' => 'uma descrição', 'due' => '01-02-2019', 'author' => 'José Filho'];
        $task2 = ['cpf' => '11.222.333.04', 'description' => 'outra descrição', 'due' => '01-02-2019', 'author' => 'José Filho'];
        $task3 = ['cpf' => '11.222.333.04', 'description' => 'a terceira descrição', 'due' => '01-02-2019', 'author' => 'José Filho'];

        return [
            $task1,
            $task2,
            $task3,
        ];
    }

    private function getStorageMock()
    {
        $tasks = $this->prepareListOfTasks();
        $storage = $this->createMock(TaskStorageAdapterInterface::class);
        $storage->expects($this->once())
            ->method('getAll')
            ->willReturn($tasks);

        return $storage;
    }

    /**
     * @test
     */
    public function shouldListAllTasks()
    {
        $allTasks = $this->prepareListOfTasks();
        $storage = $this->getStorageMock();

        $tasks = new ListTasks($storage);
        $tasks = $tasks->list();

        $this->assertCount(count($allTasks), $tasks);
    }

    /**
     * @test
     */
    public function listItemsShouldBeATaskIfNotEmpty()
    {
        $storage = $this->getStorageMock();

        $tasks = new ListTasks($storage);
        $tasks = $tasks->list();

        $this->assertInstanceOf(Task::class, $tasks[0]);
    }
}
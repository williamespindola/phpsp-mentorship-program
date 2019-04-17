<?php

declare(strict_types=1);

namespace Todo;

use Todo\Storage\TaskStorageAdapterInterface;
use DateTime;

class ListTasks
{
    private $storage;
    
    public function __construct(TaskStorageAdapterInterface $storage)
    {
        $this->storage = $storage;
    }
    
    public function list(): array
    {
        $tasksArray = $this->storage->getAll();
        $tasks = [];
        foreach($tasksArray as $task) {
            $task = new Task($task['cpf'], $task['description'], new DateTime($task['due']), $task['author']);
            $tasks[] = $task;
        }
        
        return $tasks;
    }
}
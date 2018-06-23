<?php

declare(strict_types=1);

namespace Todo;

use Exception;
use Todo\Exception\TaskException;
use Todo\Task;
use Todo\Storage\TaskStorageAdapterInterface;

class CreateTask
{
    private $storage;

    public function __construct(TaskStorageAdapterInterface $storage)
    {
        $this->storage = $storage;
    }

    public function create(Task $task) : void
    {
        try {
            $this->storage
                ->persist($task);
        } catch (Exception $exception) {
            throw TaskException::forCreateTaskError($exception->getMessage());
        }
    }
}
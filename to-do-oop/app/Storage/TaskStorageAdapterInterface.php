<?php

namespace Todo\Storage;

use Todo\Task;

interface TaskStorageAdapterInterface
{
    public function find(int $task_id) : Task;
    public function getAll() : array;
    public function persist(Task $task) : Task;
}
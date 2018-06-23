<?php

declare(strict_types=1);

namespace Todo\Exception;

use Exception;

class TaskNotFoundException extends Exception
{
    public static function notFound(int $task_id) : self
    {
        return new self("Unable to find a Task with id: " . $task_id);
    }
}
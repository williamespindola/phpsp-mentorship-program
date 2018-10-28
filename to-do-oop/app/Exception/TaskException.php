<?php

declare(strict_types=1);

namespace Todo\Exception;

use Exception;

class TaskException extends Exception
{
    public static function forCreateTaskError(string $error) : self
    {
        return new self("Unable to create Task, error: " . $error);
    }
}
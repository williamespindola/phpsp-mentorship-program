<?php

declare(strict_types=1);

namespace Todo;

use \DateTime;

class Task
{
    private $title;
    private $due;
    private $author;
    private $description;

    public function __construct(string $title, DateTime $due, string $author, string $description)
    {
        $this->title = $title;
        $this->due = $due;
        $this->author = $author;
        $this->description = $description;
    }

    public function create(string $title, DateTime $due, string $author, string $description) : Task
    {
        return new static($title, $due, $author, $description);
    }

    public function title() : string
    {
        return $this->title;
    }

    public function due() : DateTime
    {
        return $this->due;
    }

    public function author() : string
    {
        return $this->author;
    }

    public function description() : string
    {
        return $this->description;
    }
}
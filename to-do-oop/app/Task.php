<?php

declare(strict_types=1);

namespace Todo;

use \DateTime;

class Task
{
    private $cpf;
    private $due;
    private $description;
    private $author;

    public function __construct(string $cpf, string $description, DateTime $due, string $author)
    {
        $this->cpf = $cpf;
        $this->due = $due;
        $this->description = $description;
        $this->author = $author;
    }

    public function create(string $cpf, DateTime $due, string $author, string $description) : Task
    {
        return new static($cpf, $due, $author, $description);
    }

    public function cpf() : string
    {
        return $this->cpf;
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
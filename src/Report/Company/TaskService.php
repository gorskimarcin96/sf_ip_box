<?php

namespace App\Report\Company;

readonly class TaskService
{
    /**
     * @param Task[] $tasks
     */
    public function __construct(private string $name, private array $tasks)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Task[]
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }
}

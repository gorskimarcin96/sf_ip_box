<?php

namespace App\Tools;

use App\Report\Company\Task;

readonly class TaskConverter
{
    /**
     * @param Task[] $tasks
     */
    public function __construct(private array $tasks)
    {
    }

    /**
     * @return array<array<int, string|null>>
     */
    public function toArray(): array
    {
        return array_map(fn (Task $task): array => [
            $task->getTitle(),
            $task->getDescription(),
            $task->getSha(),
            $task->getStarted()?->format('Y-m-d'),
            $task->getFinished()?->format('Y-m-d'),
        ], $this->tasks);
    }

    public function toCsv(): string
    {
        $data = [['title', 'description', 'sha', 'started', 'finished'], ...$this->toArray()];

        return implode("\n", array_map(fn (array $columns): string => implode(';', $columns), $data));
    }
}

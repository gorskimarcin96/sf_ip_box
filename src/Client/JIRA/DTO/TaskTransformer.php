<?php

namespace App\Client\JIRA\DTO;

use App\Report\Company\Task;

readonly class TaskTransformer
{
    /**
     * @param array<array{fields: array{summary: string, created: string, updated: string}}> $issues
     *
     * @return Task[]
     */
    public function transform(array $issues): array
    {
        return array_map(fn (array $issue): Task => $this->transformOne($issue), $issues);
    }

    /**
     * @param array{fields: array{summary: string, created: string, updated: string}} $issue
     */
    private function transformOne(array $issue): Task
    {
        return new Task(
            $issue['fields']['summary'],
            null,
            null,
            new \DateTimeImmutable($issue['fields']['created']),
            new \DateTimeImmutable($issue['fields']['updated'])
        );
    }
}

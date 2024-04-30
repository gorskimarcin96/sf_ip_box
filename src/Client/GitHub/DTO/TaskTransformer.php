<?php

namespace App\Client\GitHub\DTO;

use App\Report\Company\Task;

readonly class TaskTransformer
{
    /**
     * @param array<array{sha: string, commit: array{message: string, author: array{date: string}}}> $commits
     *
     * @return Task[]
     */
    public function transform(array $commits): array
    {
        return array_map(fn (array $commit): Task => $this->transformOne($commit), $commits);
    }

    /**
     * @param array{sha: string, commit: array{message: string, author: array{date: string}}} $commit
     */
    private function transformOne(array $commit): Task
    {
        return new Task(
            $commit['commit']['message'],
            null,
            $commit['sha'],
            null,
            new \DateTimeImmutable($commit['commit']['author']['date']),
        );
    }
}

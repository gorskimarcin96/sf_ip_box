<?php

namespace App\Tests\Client\JIRA\DTO;

use App\Client\JIRA\DTO\TaskTransformer;
use PHPUnit\Framework\TestCase;

class TaskTransformerTest extends TestCase
{
    /**
     * @return array{array{array<array{fields: array{summary: string, created: string, updated: string}}>, array{title: string, sha: string|null, description: string|null, started: \DateTimeInterface|null, finished: \DateTimeInterface|null}}}
     */
    public function getData(): array
    {
        return [
            [
                [['fields' => ['summary' => 'title 1', 'created' => '01-01-2000', 'updated' => '02-01-2000']]],
                ['title' => 'title 1', 'sha' => null, 'description' => null, 'started' => new \DateTime('01-01-2000'), 'finished' => new \DateTime('02-01-2000')],
            ],
        ];
    }

    /**
     * @dataProvider getData
     *
     * @param array<array{fields: array{summary: string, created: string, updated: string}}>                                                        $input
     * @param array{title: string, sha: string|null, description: string|null, started: \DateTimeInterface|null, finished: \DateTimeInterface|null} $expect
     */
    public function testTransform(array $input, array $expect): void
    {
        $result = (new TaskTransformer())->transform($input);

        $this->assertIsArray($result);
        $this->assertSame($expect['title'], $result[0]->getTitle());
        $this->assertSame($expect['sha'], $result[0]->getSha());
        $this->assertSame($expect['description'], $result[0]->getDescription());
        $this->assertSame($expect['started']?->getTimestamp(), $result[0]->getStarted()?->getTimestamp());
        $this->assertSame($expect['finished']?->getTimestamp(), $result[0]->getFinished()?->getTimestamp());
    }
}

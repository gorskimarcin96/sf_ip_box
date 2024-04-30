<?php

namespace App\Tests\Client\GitHub\DTO;

use App\Client\GitHub\DTO\TaskTransformer;
use PHPUnit\Framework\TestCase;

class TaskTransformerTest extends TestCase
{
    /**
     * @return array{array{array{array{sha: string, commit: array{message: string, author: array{date: string}}}}, array{title: string, sha: string|null, description: string|null, started: \DateTimeInterface|null, finished: \DateTimeInterface|null}}}
     */
    public function getData(): array
    {
        return [
            [
                [['sha' => 'sha1', 'commit' => ['message' => 'message1', 'author' => ['date' => '01-01-2000']]]],
                ['title' => 'message1', 'sha' => 'sha1', 'description' => null, 'started' => null, 'finished' => new \DateTime('01-01-2000')],
            ],
        ];
    }

    /**
     * @dataProvider getData
     *
     * @param array<array{sha: string, commit: array{message: string, author: array{date: string}}}>                                                $input
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

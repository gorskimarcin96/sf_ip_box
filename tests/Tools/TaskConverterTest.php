<?php

namespace App\Tests\Tools;

use App\Report\Company\Task;
use App\Tools\TaskConverter;
use PHPUnit\Framework\TestCase;

class TaskConverterTest extends TestCase
{
    private TaskConverter $taskConverter;

    protected function setUp(): void
    {
        $this->taskConverter = new TaskConverter([
            new Task('title 1', 'description 1', 'sha-1', new \DateTimeImmutable('01-01-2000'), new \DateTimeImmutable('02-01-2000')),
            new Task('title 2', 'description 2', 'sha-2', new \DateTimeImmutable('01-02-2000'), new \DateTimeImmutable('02-02-2000')),
        ]);
    }

    public function testToArray(): void
    {
        $this->assertIsArray($this->taskConverter->toArray());
        $this->assertSame([
            ['title 1', 'description 1', 'sha-1', '2000-01-01', '2000-01-02'],
            ['title 2', 'description 2', 'sha-2', '2000-02-01', '2000-02-02'],
        ], $this->taskConverter->toArray());
    }

    public function testToCsv(): void
    {
        $this->assertIsString($this->taskConverter->toCsv());
        $this->assertSame("title;description;sha;started;finished\ntitle 1;description 1;sha-1;2000-01-01;2000-01-02\ntitle 2;description 2;sha-2;2000-02-01;2000-02-02", $this->taskConverter->toCsv());
    }
}

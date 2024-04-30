<?php

namespace App\Tests\Report\Company;

use App\Report\Company\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();

        $this->task = new Task('title', 'description', 'sha', new \DateTimeImmutable('01-01-2000'), new \DateTimeImmutable('02-01-2000'));
    }

    public function testGetTitle(): void
    {
        $this->assertSame('title', $this->task->getTitle());
    }

    public function testGetDescription(): void
    {
        $this->assertSame('description', $this->task->getDescription());
    }

    public function testGetSha(): void
    {
        $this->assertSame('sha', $this->task->getSha());
    }

    public function testGetStarted(): void
    {
        $this->assertSame(946684800, $this->task->getStarted()?->getTimestamp());
    }

    public function testGetFinished(): void
    {
        $this->assertSame(946771200, $this->task->getFinished()?->getTimestamp());
    }
}

<?php

namespace App\Tests\Report\Company;

use App\Report\Company\Task;
use App\Report\Company\TaskService;
use PHPUnit\Framework\TestCase;

class TaskServiceTest extends TestCase
{
    private TaskService $taskService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskService = new TaskService('task service name', [
            new Task('title', 'description', 'sha', new \DateTimeImmutable('01-01-2000'), new \DateTimeImmutable('02-01-2000')),
        ]);
    }

    public function testGetName(): void
    {
        $this->assertSame('task service name', $this->taskService->getName());
    }

    public function testGetTasks(): void
    {
        $result = $this->taskService->getTasks();

        $this->assertIsArray($result);
        $this->assertInstanceOf(Task::class, $result[0]);
    }
}

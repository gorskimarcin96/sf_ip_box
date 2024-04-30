<?php

namespace App\Tests\Report\Company;

use App\Client\GitHub\Client as GitHub;
use App\Client\JIRA\Client as JIRA;
use App\Report\Company\ACube;
use App\Report\Company\Task;
use App\Report\Company\TaskService;
use PHPUnit\Framework\TestCase;

class ACubeTest extends TestCase
{
    public function testGetName(): void
    {
        $company = new ACube($this->createMock(JIRA::class), $this->createMock(GitHub::class));

        $this->assertSame('ACube', $company->getName());
    }

    public function testGetTaskServices(): void
    {
        $company = $this->createMock(ACube::class);
        $company
            ->expects(self::once())
            ->method('getTaskServices')
            ->willReturn([new TaskService('Test', [new Task('title', 'description', 'sha', new \DateTimeImmutable('01-01-2000'), new \DateTimeImmutable('02-01-2000'))])]);

        $this->assertIsArray($company->getTaskServices(2024));
    }
}

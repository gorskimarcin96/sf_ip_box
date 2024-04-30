<?php

namespace App\Tests\Command;

use App\Command\IPBoxGeneratorCommand;
use App\Report\Company\ACube;
use App\Report\Company\Task;
use App\Report\Company\TaskService;
use App\Report\Factory\CompanyReports2024;
use App\Report\Factory\ReportYear;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

class IPBoxGeneratorCommandTest extends KernelTestCase
{
    public function testExecuteSuccess(): void
    {
        $ACube = $this->createMock(ACube::class);
        $ACube
            ->method('getName')
            ->willReturn('company');
        $ACube
            ->expects(self::once())
            ->method('getTaskServices')
            ->willReturn([new TaskService('task_service', [
                new Task('First task', 'its so hard task...', 'sha', new \DateTimeImmutable('01-01-2000'), new \DateTimeImmutable('02-01-2000')),
                new Task('Second task', 'how did i do it?', 'sha', new \DateTimeImmutable('01-01-2000'), new \DateTimeImmutable('02-01-2000')),
            ])]);

        $command = new CommandTester(new IPBoxGeneratorCommand(new ReportYear(new CompanyReports2024($ACube)), new Filesystem()));
        $command->execute(['year' => '2024']);

        $command->assertCommandIsSuccessful();
        $this->assertSame(Command::SUCCESS, $command->getStatusCode());
        $this->assertStringContainsString('[NOTE] Generating reports for year 2024', $command->getDisplay());
        $this->assertStringContainsString('Generating reports for company: company', $command->getDisplay());
        $this->assertStringContainsString('[OK] Your reports is generated.', $command->getDisplay());
    }

    public function testExecuteFail(): void
    {
        $command = new CommandTester(new IPBoxGeneratorCommand(new ReportYear(new CompanyReports2024($this->createMock(ACube::class))), new Filesystem()));
        $command->execute(['year' => '2023']);

        $this->assertSame(Command::FAILURE, $command->getStatusCode());
        $this->assertStringContainsString('[ERROR] LogicException: Report for year 2023 is not defined.', $command->getDisplay());
    }
}

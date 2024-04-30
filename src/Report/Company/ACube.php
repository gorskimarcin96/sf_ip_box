<?php

namespace App\Report\Company;

use App\Client\GitHub\Client as GitHub;
use App\Client\JIRA\Client as JIRA;

class ACube implements CompanyInterface
{
    public function __construct(private readonly JIRA $JIRA, private readonly GitHub $gitHub)
    {
    }

    #[\Override]
    public function getName(): string
    {
        return 'ACube';
    }

    /**
     * @return TaskService[]
     */
    #[\Override]
    public function getTaskServices(int $year): array
    {
        $company = 'a-cube-io';
        $repositories = ['stripe-backend', 'stripe-app', 'gov-pl-ksef-client', 'gov-pl-api', 'gov-it-api'];
        $taskServices = array_map(fn (string $repository): TaskService => new TaskService('GitHub_'.$repository, $this->getTasksFromGithub($year, $company, $repository)), $repositories);

        return [
            ...$taskServices,
            new TaskService('JIRA', $this->getTasksFromJira($year)),
        ];
    }

    /**
     * @return Task[]
     */
    private function getTasksFromJira(int $year): array
    {
        return $this->JIRA->getIssues(
            $_ENV['A_CUBE_JIRA_TOKEN'],
            'a-cube',
            $_ENV['A_CUBE_EMAIL'],
            sprintf('assignee=%s AND created >= "%s-01-01" AND created <= "%s-12-31"', $_ENV['A_CUBE_JIRA_ACCOUNT_ID'], $year, $year)
        );
    }

    /**
     * @return Task[]
     */
    private function getTasksFromGithub(int $year, string $company, string $repository): array
    {
        $from = new \DateTimeImmutable('01-01-'.$year);
        $to = $from->modify('last day of December');

        return $this->gitHub->getCommits($_ENV['GITHUB_TOKEN'], $company, $repository, [
            'author' => $_ENV['GITHUB_EMAIL'],
            'since' => $from->format(\DateTimeInterface::ISO8601_EXPANDED),
            'until' => $to->format(\DateTimeInterface::ISO8601_EXPANDED),
        ]);
    }
}

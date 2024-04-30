<?php

namespace App\Tests\Client\JIRA;

use App\Client\JIRA\Client;
use App\Client\JIRA\DTO\TaskTransformer;
use App\Client\Mock\HttpClient;
use App\Report\Company\Task;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testGetIssues(): void
    {
        $client = new Client(HttpClient::create()->addRequest(
            'GET',
            'https://company.atlassian.net/rest/api/3/search',
            '{"issues":[{"fields":{"summary":"title 1","created":"2000-01-01","updated":"2000-01-02"}}],"total":1}'
        ), new TaskTransformer());

        $tasks = $client->getIssues('token', 'company', 'example@test', '');

        $this->assertIsArray($tasks);
        $this->assertInstanceOf(Task::class, $tasks[0]);
    }
}

<?php

namespace App\Tests\Client\GitHub;

use App\Client\GitHub\Client;
use App\Client\GitHub\DTO\TaskTransformer;
use App\Client\Mock\HttpClient;
use App\Report\Company\Task;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testGetCommits(): void
    {
        $client = new Client(HttpClient::create()->addRequest(
            'GET',
            'https://api.github.com/repos/company/repository/commits?',
            '[{"sha":"sha","commit":{"message":"message","author":{"date": "2000-01-01"}}}]'
        ), new TaskTransformer());

        $tasks = $client->getCommits('token', 'company', 'repository');

        $this->assertIsArray($tasks);
        $this->assertInstanceOf(Task::class, $tasks[0]);
    }
}

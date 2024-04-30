<?php

namespace App\Client\JIRA;

use App\Client\JIRA\DTO\TaskTransformer;
use App\Report\Company\Task;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    public const URL = 'atlassian.net';

    public function __construct(private readonly HttpClientInterface $httpClient, private readonly TaskTransformer $taskTransformer)
    {
    }

    /**
     * @return Task[]
     */
    public function getIssues(string $token, string $subdomain, string $email, string $jql): array
    {
        [$limit, $page, $issues] = [100, 0, []];

        do {
            $result = $this->httpClient->request('GET', 'https://'.$subdomain.'.'.self::URL.'/rest/api/3/search', [
                'auth_basic' => [$email, $token],
                'query' => [
                    'jql' => $jql,
                    'startAt' => $page * $limit,
                    'maxResults' => $limit,
                ],
            ])->toArray();

            $issues = [...$issues, ...$result['issues']];
        } while ($result['total'] > $page * $limit && $page++);

        return $this->taskTransformer->transform($issues);
    }
}

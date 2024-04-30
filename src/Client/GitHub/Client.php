<?php

namespace App\Client\GitHub;

use App\Client\GitHub\DTO\TaskTransformer;
use App\Report\Company\Task;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    public const URL = 'https://api.github.com';

    public function __construct(private readonly HttpClientInterface $httpClient, private readonly TaskTransformer $taskTransformer)
    {
    }

    /**
     * @param array<string, string> $query
     *
     * @return Task[]
     */
    public function getCommits(string $token, string $company, string $repository, array $query = []): array
    {
        $data = $this->httpClient->request('GET', self::URL.'/repos/'.$company.'/'.$repository.'/commits?'.http_build_query($query), [
            'headers' => ['Authorization' => 'Bearer '.$token],
        ])->toArray();

        return $this->taskTransformer->transform($data);
    }
}

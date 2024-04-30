<?php

namespace App\Tests\Client\Mock;

use App\Client\Mock\HttpClient;
use App\Client\Mock\Response;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpClientTest extends TestCase
{
    public function testRequest(): void
    {
        $httpClient = HttpClient::create()->addRequest('GET', 'https://example.com', '{}');
        $result = $httpClient->request('GET', 'https://example.com');

        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    public function testAddRequest(): void
    {
        $httpClient = HttpClient::create()->addRequest('GET', 'https://example.com', '{}');
        $result = $httpClient->request('GET', 'https://example.com');

        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    public function testStream(): void
    {
        $this->expectException(\LogicException::class);

        HttpClient::create()->stream(new Response('{}'));
    }

    public function testCreate(): void
    {
        $this->assertInstanceOf(HttpClient::class, HttpClient::create());
    }

    public function testWithOptions(): void
    {
        $this->expectException(\LogicException::class);

        HttpClient::create()->withOptions([]);
    }
}

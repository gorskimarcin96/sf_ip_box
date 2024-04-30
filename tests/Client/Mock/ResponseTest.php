<?php

namespace App\Tests\Client\Mock;

use App\Client\Mock\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testGetStatusCode(): void
    {
        $response = new Response('{}');

        $this->assertSame(200, $response->getStatusCode());
    }

    public function testToArray(): void
    {
        $response = new Response('{}');

        $this->assertSame([], $response->toArray());
    }

    public function testCancel(): void
    {
        $this->expectException(\LogicException::class);

        $response = new Response('{}');
        $response->cancel();
    }

    public function testGetContent(): void
    {
        $response = new Response('{}');

        $this->assertSame('{}', $response->getContent());
    }

    public function testGetHeaders(): void
    {
        $this->expectException(\LogicException::class);

        $response = new Response('{}');
        $response->getHeaders();
    }

    public function testGetInfo(): void
    {
        $this->expectException(\LogicException::class);

        $response = new Response('{}');
        $response->getInfo();
    }
}

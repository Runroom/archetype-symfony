<?php

namespace Tests\E2E;

use Symfony\Component\Panther\Client as PantherClient;
use Symfony\Component\Panther\PantherTestCase;

abstract class AbstractPantherTestCase extends PantherTestCase
{
    protected PantherClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createPantherClient();
    }

    protected function assertSuccessResponse(): void
    {
        $this->assertEquals(200, $this->client->getInternalResponse()->getStatusCode());
    }

    protected function assertNotFoundResponse(): void
    {
        $this->assertEquals(404, $this->client->getInternalResponse()->getStatusCode());
    }

    protected function assertInternalErrorResponse(): void
    {
        $this->assertEquals(500, $this->client->getInternalResponse()->getStatusCode());
    }
}

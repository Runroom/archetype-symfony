<?php


namespace Tests\Unit;


use Symfony\Component\Panther\PantherTestCase;
use Symfony\Component\Panther\Client as PantherClient;

class MyPantherTest extends PantherTestCase
{
    private PantherClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createPantherClient();
    }

    public function testHomePage(): void
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertSuccessResponse();

        $this->assertPageTitleContains('Archetype Symfony');
        $this->assertSelectorIsVisible('#header');
        $this->assertSelectorIsVisible('#main');
        $this->assertSelectorIsVisible('#footer');
        $this->assertSelectorIsVisible('.demo');
    }

    public function testHomePageLinks(): void
    {
        // Links by text
        $links = [
            'Basic Entities',
            'Forms',
            'Forms Ajax',
            'Cookie Policy',
            'Privacy policy',
        ];

        foreach ($links as $link) {
            $this->assertLinkResponseSuccessByText($link);
        }

        // Links by selector
        $linksSelectors = [
            '.header__logo',
        ];

        foreach ($linksSelectors as $linkSelector) {
            $this->assertLinkResponseSuccessBySelector($linkSelector);
        }
    }

    private function assertLinkResponseSuccessBySelector(string $selector): void
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertSuccessResponse();

        $homeLink = $crawler->filter($selector);
        $homeLink->click();
        $this->assertSuccessResponse();
    }

    private function assertLinkResponseSuccessByText(string $linkText): void
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertSuccessResponse();

        $this->client->clickLink($linkText);
        $this->assertSuccessResponse();
    }

    private function assertSuccessResponse(): void
    {
        $this->assertEquals(200, $this->client->getInternalResponse()->getStatusCode());
    }

    private function assertNotFoundResponse(): void
    {
        $this->assertEquals(404, $this->client->getInternalResponse()->getStatusCode());
    }

    private function assertInternalErrorResponse(): void
    {
        $this->assertEquals(500, $this->client->getInternalResponse()->getStatusCode());
    }
}

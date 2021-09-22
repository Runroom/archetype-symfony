<?php


namespace Tests\E2E;


class HomePageTest extends AbstractPantherTestCase
{
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
}

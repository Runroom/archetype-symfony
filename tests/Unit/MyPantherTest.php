<?php


namespace Tests\Unit;


use Symfony\Component\Panther\PantherTestCase;

class MyPantherTest extends PantherTestCase
{
    public function testSomething(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');

        $this->assertPageTitleContains('Archetype Symfony');
        $this->assertSelectorIsVisible('#header');
        $this->assertSelectorIsVisible('#main');
        $this->assertSelectorIsVisible('#footer');
        $this->assertSelectorIsVisible('.demo');

        $client->clickLink('Basic Entities');
        $this->assertSelectorNotExists('.demo');

        $client->clickLink('Cookie Policy');
        $this->assertPageTitleContains('Cookies | Archetype Symfony');
    }
}

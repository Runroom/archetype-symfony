<?php

namespace Tests\E2E;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class HomePageTest extends KernelTestCase
{
    use HasBrowser;

    public function testHomePage(): void
    {
        $this->browser()
            ->visit('/')
            ->assertSuccessful()
            ->assertSeeElement('#header')
            ->assertSeeElement('#main')
            ->assertSeeElement('#footer')
            ->assertSeeElement('.demo');
    }

    /**
     * @dataProvider homePageLinks
     */
    public function testHomePageLinks(string $link): void
    {
        $this->browser()
            ->visit('/')
            ->assertSuccessful()
            ->click($link)
            ->assertSuccessful();
    }

    public function homePageLinks(): iterable
    {
        return [
            ['Basic Entities'],
            ['Forms'],
            ['Forms Ajax'],
            ['Cookie Policy'],
            ['Privacy policy'],
        ];
    }
}

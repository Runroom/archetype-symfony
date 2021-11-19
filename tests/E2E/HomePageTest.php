<?php

declare(strict_types=1);

namespace Tests\E2E;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;

class HomePageTest extends KernelTestCase
{
    use HasBrowser;
    use ResetDatabase;

    /** @test */
    public function itLoadsHomePage(): void
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
     *
     * @test
     */
    public function itLoadsHomePageLinks(string $link): void
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

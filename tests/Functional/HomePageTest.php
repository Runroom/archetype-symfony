<?php

declare(strict_types=1);

namespace Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;

final class HomePageTest extends KernelTestCase
{
    use HasBrowser;
    use ResetDatabase;

    public function testItLoadsHomePage(): void
    {
        $this->browser()
            ->visit('/')
            ->assertSuccessful()
            ->assertSeeElement('#header')
            ->assertSeeElement('#main')
            ->assertSeeElement('#footer')
            ->assertSeeElement('.wrapper');
    }

    /**
     * @dataProvider homePageLinks
     */
    /* public function testItLoadsHomePageLinks(string $link): void
    {
        $this->browser()
            ->visit('/')
            ->assertSuccessful()
            ->click($link)
            ->assertSuccessful();
    } */

    /**
     * @return array<int, array<string>>
     */
    /* public function homePageLinks(): iterable
    {
        return [
            ['Basic Entities'],
            ['Forms'],
            ['Forms Ajax'],
            ['Cookie Policy'],
            ['Privacy policy'],
        ];
    } */
}

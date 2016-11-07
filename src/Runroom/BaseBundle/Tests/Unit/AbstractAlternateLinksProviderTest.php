<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Runroom\BaseBundle\Service\AlternateLinksProvider\AbstractAlternateLinksProvider;

class AbstractAlternateLinksProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->router = $this->prophesize('Symfony\Bundle\FrameworkBundle\Routing\Router');
        $this->locales = ['es', 'en', 'ca'];

        $this->provider = new TestAlternateLinksProvider(
            $this->router->reveal(),
            $this->locales
        );
    }

    /**
     * @test
     */
    public function itDoesNotProvideAnyAlternateLinks()
    {
        $base_routes = ['default', 'home', 'case_study', 'services'];

        foreach ($base_routes as $base_route) {
            $this->assertFalse($this->provider->providesAlternateLinks($base_route));
        }
    }

    /**
     * @test
     */
    public function itFindsAlternateLinksForRoute()
    {
        $base_route = 'base_route';
        $model = 'model';

        foreach ($this->locales as $locale) {
            $this->router->generate(
                    $base_route . '.' . $locale,
                    []
                )
                ->willReturn($locale);
        }

        $alternate_links = $this->provider->findAlternateLinksFor($base_route, $model);

        foreach ($this->locales as $locale) {
            $this->assertArraySubset([$locale => $locale], $alternate_links);
        }
    }

    /**
     * @test
     */
    public function itReturnsEmptyAlternateLinksIfRouteDoesNotExist()
    {
        $base_route = 'base_route';
        $model = 'model';

        $this->router->generate(
                $base_route . '.' . $this->locales[0],
                []
            )
            ->willThrow('Exception');

        $alternate_links = $this->provider->findAlternateLinksFor($base_route, $model);

        $this->assertEmpty($alternate_links);
    }
}

class TestAlternateLinksProvider extends AbstractAlternateLinksProvider
{
    public function getRouteParameters($model, $locale)
    {
        return [];
    }
}

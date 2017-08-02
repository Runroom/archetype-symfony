<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Service\AlternateLinksProvider\AbstractAlternateLinksProvider;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class AbstractAlternateLinksProviderTest extends TestCase
{
    public function setUp()
    {
        $this->router = $this->prophesize('Symfony\Bundle\FrameworkBundle\Routing\Router');
        $this->requestStack = $this->prophesize('Symfony\Component\HttpFoundation\RequestStack');
        $this->request = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        $this->query = $this->prophesize('Symfony\Component\HttpFoundation\ParameterBag');
        $this->locales = ['es', 'en'];

        $this->query->all()->willReturn([]);
        $this->requestStack->getCurrentRequest()->willReturn($this->request->reveal());

        $this->request->query = $this->query->reveal();

        $this->provider = new TestAlternateLinksProvider(
            $this->router->reveal(),
            $this->requestStack->reveal(),
            $this->locales
        );
    }

    /**
     * @test
     */
    public function itDoesNotProvideAnyAlternateLinks()
    {
        $routes = ['default', 'home'];

        foreach ($routes as $route) {
            $this->assertFalse($this->provider->providesAlternateLinks($route));
        }
    }

    /**
     * @test
     */
    public function itFindsAlternateLinksForRoute()
    {
        $route = 'base_route';
        $model = 'model';

        foreach ($this->locales as $locale) {
            $this->router->generate(
                $route . '.' . $locale,
                [],
                Router::ABSOLUTE_URL
            )->willReturn($locale);
        }

        $alternate_links = $this->provider->findAlternateLinksFor($route, $model);

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
            [],
            Router::ABSOLUTE_URL
        )->willThrow('Exception');

        $alternate_links = $this->provider->findAlternateLinksFor($base_route, $model);

        $this->assertEmpty($alternate_links);
    }
}

class TestAlternateLinksProvider extends AbstractAlternateLinksProvider
{
    public function getRouteParameters($model, string $locale): array
    {
        return [];
    }
}

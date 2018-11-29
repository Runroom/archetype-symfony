<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Service\AlternateLinksProvider\AbstractAlternateLinksProvider;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class AbstractAlternateLinksProviderTest extends TestCase
{
    protected function setUp()
    {
        $this->router = $this->prophesize(Router::class);
        $this->requestStack = $this->prophesize(RequestStack::class);
        $this->request = $this->prophesize(Request::class);
        $this->query = $this->prophesize(ParameterBag::class);
        $this->locales = ['es', 'en'];
        $this->xdefaultLocale = 'en';

        $this->query->all()->willReturn([]);
        $this->requestStack->getCurrentRequest()->willReturn($this->request->reveal());

        $this->request->query = $this->query->reveal();

        $this->provider = new TestAlternateLinksProvider(
            $this->router->reveal(),
            $this->requestStack->reveal(),
            $this->locales,
            $this->xdefaultLocale
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

    /**
     * @test
     */
    public function itReturnsAlternateLinksWithXdefault()
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
        $this->assertCount(3, $alternate_links);
    }

    /**
     * @test
     */
    public function itReturnsAlternateLinksWithoutXdefault()
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

        $customProvider = new TestAlternateLinksProvider(
            $this->router->reveal(),
            $this->requestStack->reveal(),
            $this->locales,
            null
        );
        
        $alternate_links = $customProvider->findAlternateLinksFor($route, $model);
        $this->assertCount(2, $alternate_links);
    }
}

class TestAlternateLinksProvider extends AbstractAlternateLinksProvider
{
    public function getRouteParameters($model, string $locale): array
    {
        return [];
    }
}

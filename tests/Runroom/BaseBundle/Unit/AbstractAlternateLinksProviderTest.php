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
        $this->request_stack = $this->prophesize('Symfony\Component\HttpFoundation\RequestStack');
        $this->request = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        $this->query = $this->prophesize('Symfony\Component\HttpFoundation\ParameterBag');
        $this->locales = ['es', 'en'];

        $this->query->all()
            ->willReturn([]);

        $this->request_stack->getCurrentRequest()
            ->willReturn($this->request->reveal());

        $this->request->query = $this->query->reveal();

        $this->provider = new TestAlternateLinksProvider(
            $this->router->reveal(),
            $this->request_stack->reveal(),
            $this->locales
        );
    }

    /**
     * @test
     */
    public function itDoesNotProvideAnyAlternateLinks()
    {
        $base_routes = ['default', 'home'];

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
                [],
                Router::ABSOLUTE_URL
            )->willReturn($locale);
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
            [],
            Router::ABSOLUTE_URL
        )->willThrow('Exception');

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

<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Service\AlternateLinksProvider\DefaultAlternateLinksProvider;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RequestStack;

class DefaultAlternateLinksProviderTest extends TestCase
{
    protected function setUp()
    {
        $this->router = $this->prophesize(Router::class);
        $this->requestStack = $this->prophesize(RequestStack::class);
        $this->locales = ['es', 'en'];
        $this->xdefaultLocale = 'en';

        $this->provider = new DefaultAlternateLinksProvider(
            $this->router->reveal(),
            $this->requestStack->reveal(),
            $this->locales,
            $this->xdefaultLocale
        );
    }

    /**
     * @test
     */
    public function itReturnsEmptyArrayAsRouteParameters()
    {
        foreach ($this->locales as $locale) {
            $this->assertEmpty($this->provider->getRouteParameters('model', $locale));
        }
    }

    /**
     * @test
     */
    public function itProvidesAnyAlternateLinks()
    {
        $base_routes = ['default', 'home'];

        foreach ($base_routes as $base_route) {
            $this->assertTrue($this->provider->providesAlternateLinks($base_route));
        }
    }
}

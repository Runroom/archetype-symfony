<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Runroom\BaseBundle\Service\AlternateLinksProvider\DefaultAlternateLinksProvider;

class DefaultAlternateLinksProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->router = $this->prophesize('Symfony\Bundle\FrameworkBundle\Routing\Router');
        $this->request_stack = $this->prophesize('Symfony\Component\HttpFoundation\RequestStack');
        $this->locales = ['es', 'en'];

        $this->provider = new DefaultAlternateLinksProvider(
            $this->router->reveal(),
            $this->request_stack->reveal(),
            $this->locales
        );
    }

    /**
     * @test
     */
    public function itReturnsEmptyArrayAsRouteParameters()
    {
        $model = 'model';

        foreach ($this->locales as $locale) {
            $this->assertEmpty($this->provider->getRouteParameters($model, $locale));
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

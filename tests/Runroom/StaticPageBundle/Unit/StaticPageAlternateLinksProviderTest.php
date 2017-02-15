<?php

namespace Tests\Runroom\StaticPageBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\StaticPageBundle\Service\StaticPageAlternateLinksProvider;
use Tests\Runroom\StaticPageBundle\MotherObject\StaticPageMotherObject;

class StaticPageAlternateLinksProviderTest extends TestCase
{
    const META_ROUTE = 'runroom.static_page.route.static.static';

    public function setUp()
    {
        $this->router = $this->prophesize('Symfony\Bundle\FrameworkBundle\Routing\Router');
        $this->request_stack = $this->prophesize('Symfony\Component\HttpFoundation\RequestStack');
        $this->locales = ['es', 'en'];

        $this->provider = new StaticPageAlternateLinksProvider(
            $this->router->reveal(),
            $this->request_stack->reveal(),
            $this->locales
        );
    }

    /**
     * @test
     */
    public function itReturnsRouteParameters()
    {
        $static_page = StaticPageMotherObject::createWithSlugs($this->locales);

        $model = $this->prophesize('Runroom\StaticPageBundle\ViewModel\StaticPageViewModel');

        $model->getStaticPage()->willReturn($static_page);

        foreach ($this->locales as $locale) {
            $route_parameters = $this->provider->getRouteParameters($model->reveal(), $locale);

            $this->assertSame(['static_page_slug' => 'slug_' . $locale], $route_parameters);
        }
    }

    /**
     * @test
     */
    public function itProvidesAlternateLinks()
    {
        $provided_base_routes = [self::META_ROUTE];

        foreach ($provided_base_routes as $base_route) {
            $this->assertTrue($this->provider->providesAlternateLinks($base_route));
        }
    }
}

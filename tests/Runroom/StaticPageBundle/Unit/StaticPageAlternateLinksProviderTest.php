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
        $this->requestStack = $this->prophesize('Symfony\Component\HttpFoundation\RequestStack');
        $this->locales = ['es', 'en'];

        $this->provider = new StaticPageAlternateLinksProvider(
            $this->router->reveal(),
            $this->requestStack->reveal(),
            $this->locales
        );
    }

    /**
     * @test
     */
    public function itReturnsRouteParameters()
    {
        $staticPage = StaticPageMotherObject::createWithSlugs($this->locales);

        $model = $this->prophesize('Runroom\StaticPageBundle\ViewModel\StaticPageViewModel');

        $model->getStaticPage()->willReturn($staticPage);

        foreach ($this->locales as $locale) {
            $routeParameters = $this->provider->getRouteParameters($model->reveal(), $locale);

            $this->assertSame(['staticPageSlug' => 'slug_' . $locale], $routeParameters);
        }
    }

    /**
     * @test
     */
    public function itProvidesAlternateLinks()
    {
        $routes = [self::META_ROUTE];

        foreach ($routes as $route) {
            $this->assertTrue($this->provider->providesAlternateLinks($route));
        }
    }
}

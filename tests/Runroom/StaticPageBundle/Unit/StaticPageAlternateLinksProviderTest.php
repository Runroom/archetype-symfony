<?php

namespace Tests\Runroom\StaticPageBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\StaticPageBundle\Service\StaticPageAlternateLinksProvider;
use Runroom\StaticPageBundle\ViewModel\StaticPageViewModel;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RequestStack;
use Tests\Runroom\StaticPageBundle\MotherObject\StaticPageMotherObject;

class StaticPageAlternateLinksProviderTest extends TestCase
{
    const META_ROUTE = 'runroom.static_page.route.static.static';

    protected function setUp()
    {
        $this->router = $this->prophesize(Router::class);
        $this->requestStack = $this->prophesize(RequestStack::class);
        $this->locales = ['es', 'en'];
        $this->xdefaultLocale = 'en';

        $this->provider = new StaticPageAlternateLinksProvider(
            $this->router->reveal(),
            $this->requestStack->reveal(),
            $this->locales,
            $this->xdefaultLocale
        );
    }

    /**
     * @test
     */
    public function itReturnsRouteParameters()
    {
        $staticPage = StaticPageMotherObject::createWithSlugs($this->locales);

        $model = $this->prophesize(StaticPageViewModel::class);

        $model->getStaticPage()->willReturn($staticPage);

        foreach ($this->locales as $locale) {
            $routeParameters = $this->provider->getRouteParameters($model->reveal(), $locale);

            $this->assertSame(['slug' => 'slug_' . $locale], $routeParameters);
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

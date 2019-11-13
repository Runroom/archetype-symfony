<?php

namespace Tests\Runroom\StaticPageBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\StaticPageBundle\Service\StaticPageAlternateLinksProvider;
use Runroom\StaticPageBundle\ViewModel\StaticPageViewModel;
use Tests\Runroom\StaticPageBundle\Fixtures\StaticPageFixture;

class StaticPageAlternateLinksProviderTest extends TestCase
{
    const META_ROUTE = 'runroom.static_page.route.static';

    protected $locales;
    protected $provider;

    protected function setUp(): void
    {
        $this->locales = ['es', 'en'];

        $this->provider = new StaticPageAlternateLinksProvider();
    }

    /**
     * @test
     */
    public function itReturnsRouteParameters()
    {
        $staticPage = StaticPageFixture::createWithSlugs($this->locales);

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

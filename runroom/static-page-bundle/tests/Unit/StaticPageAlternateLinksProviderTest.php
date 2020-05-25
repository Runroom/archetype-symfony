<?php

namespace Runroom\StaticPageBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Runroom\StaticPageBundle\Service\StaticPageAlternateLinksProvider;
use Runroom\StaticPageBundle\Tests\Fixtures\StaticPageFixture;
use Runroom\StaticPageBundle\ViewModel\StaticPageViewModel;

class StaticPageAlternateLinksProviderTest extends TestCase
{
    use ProphecyTrait;

    protected const META_ROUTE = 'runroom.static_page.route.static';

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
            $routeParameters = $this->provider->getParameters($model->reveal(), $locale);

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

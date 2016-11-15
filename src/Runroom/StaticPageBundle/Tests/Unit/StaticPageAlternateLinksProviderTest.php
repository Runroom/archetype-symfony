<?php

namespace Runroom\StaticPageBundle\Tests\Unit;

use Runroom\StaticPageBundle\Service\StaticPageAlternateLinksProvider;
use Runroom\StaticPageBundle\Tests\MotherObject\StaticPageMotherObject;

class StaticPageAlternateLinksProviderTest extends \PHPUnit_Framework_TestCase
{
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
        $case_study = StaticPageMotherObject::createWithSlugs($this->locales);

        $model = $this->prophesize('Runroom\StaticPageBundle\ViewModel\StaticPageViewModel');

        $model->getStaticPage()
            ->willReturn($case_study);

        foreach ($this->locales as $locale) {
            $route_parameters = $this->provider->getRouteParameters($model->reveal(), $locale);

            $this->assertEquals(
                ['static_page_slug' => 'slug_' . $locale],
                $route_parameters
            );
        }
    }

    /**
     * @test
     */
    public function itProvidesAlternateLinks()
    {
        $provided_base_routes = ['runroom.static_page.route.static.static'];
        $non_provided_base_routes = ['default', 'runroom.runroom.home'];

        foreach ($provided_base_routes as $base_route) {
            $this->assertTrue($this->provider->providesAlternateLinks($base_route));
        }

        foreach ($non_provided_base_routes as $base_route) {
            $this->assertFalse($this->provider->providesAlternateLinks($base_route));
        }
    }
}

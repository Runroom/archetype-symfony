<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Runroom\BaseBundle\Service\AlternateLinksProvider\StaticPageAlternateLinksProvider;
use Runroom\BaseBundle\Tests\MotherObject\StaticPageMotherObject;

class StaticPageAlternateLinksProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->router = $this->prophesize('Symfony\Bundle\FrameworkBundle\Routing\Router');
        $this->locales = ['es', 'en', 'ca'];

        $this->provider = new StaticPageAlternateLinksProvider(
            $this->router->reveal(),
            $this->locales
        );
    }

    /**
     * @test
     */
    public function itReturnsRouteParameters()
    {
        $case_study = StaticPageMotherObject::createWithSlugs($this->locales);

        $model = $this->prophesize('Runroom\BaseBundle\ViewModel\StaticPageViewModel');

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
        $provided_base_routes = ['runroom.base.route.static'];
        $non_provided_base_routes = ['default', 'runroom.runroom.home'];

        foreach ($provided_base_routes as $base_route) {
            $this->assertTrue($this->provider->providesAlternateLinks($base_route));
        }

        foreach ($non_provided_base_routes as $base_route) {
            $this->assertFalse($this->provider->providesAlternateLinks($base_route));
        }
    }
}

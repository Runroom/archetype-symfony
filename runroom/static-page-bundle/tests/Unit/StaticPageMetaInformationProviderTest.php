<?php

namespace Runroom\StaticPageBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Runroom\SeoBundle\Entity\EntityMetaInformation;
use Runroom\StaticPageBundle\Service\StaticPageMetaInformationProvider;
use Runroom\StaticPageBundle\Tests\Fixtures\StaticPageFixture;
use Runroom\StaticPageBundle\ViewModel\StaticPageViewModel;

class StaticPageMetaInformationProviderTest extends TestCase
{
    use ProphecyTrait;

    protected const META_ROUTE = 'runroom.static_page.route.static';

    protected $model;
    protected $staticPage;
    protected $provider;

    protected function setUp(): void
    {
        $this->model = $this->prophesize(StaticPageViewModel::class);

        $this->staticPage = StaticPageFixture::create();
        $this->provider = new StaticPageMetaInformationProvider();

        $this->model->getStaticPage()->willReturn($this->staticPage);
    }

    /**
     * @test
     */
    public function itProvidesMetasForStaticPageRoutes()
    {
        $routes = [self::META_ROUTE];

        foreach ($routes as $route) {
            $this->assertTrue($this->provider->providesMetas($route));
        }
    }

    /**
     * @test
     */
    public function itHasPlaceholders()
    {
        $expectedPlaceholders = [
            '{title}' => StaticPageFixture::TITLE,
            '{content}' => StaticPageFixture::CONTENT,
        ];

        $placeholders = $this->provider->getPlaceholders($this->model->reveal());

        $this->assertSame($expectedPlaceholders, $placeholders);
    }

    /**
     * @test
     */
    public function itHasAnEntityMetaInformation()
    {
        $entityMetas = $this->provider->getEntityMetaInformation($this->model->reveal());

        $this->assertInstanceOf(EntityMetaInformation::class, $entityMetas);
    }
}

<?php

namespace Tests\Runroom\StaticPageBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\StaticPageBundle\Service\StaticPageMetaInformationProvider;
use Tests\Runroom\BaseBundle\MotherObject\MetaInformationMotherObject;
use Tests\Runroom\StaticPageBundle\MotherObject\StaticPageMotherObject;

class StaticPageMetaInformationProviderTest extends TestCase
{
    const META_ROUTE = 'runroom.static_page.route.static.static';

    const TITLE = 'Title';
    const CONTENT = 'Content';

    public function setUp()
    {
        $this->repository = $this->prophesize('Runroom\BaseBundle\Repository\MetaInformationRepository');
        $this->model = $this->prophesize('Runroom\StaticPageBundle\ViewModel\StaticPageViewModel');

        $this->staticPage = StaticPageMotherObject::createWithTitleAndContent(self::TITLE, self::CONTENT);
        $this->provider = new StaticPageMetaInformationProvider($this->repository->reveal());

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
    public function itReplacesPlaceholders()
    {
        $placeholders = [
            'Test {title}' => 'Test ' . self::TITLE,
            'Test {content}' => 'Test ' . self::CONTENT,
        ];

        foreach ($placeholders as $placeholder => $expectedValue) {
            $metas = MetaInformationMotherObject::create($placeholder, $placeholder);

            $this->repository->findOneByRoute(self::META_ROUTE)->willReturn($metas);
            $metas = $this->provider->findMetasFor(self::META_ROUTE, $this->model->reveal());

            $this->assertSame($expectedValue, $metas->getTitle());
            $this->assertSame($expectedValue, $metas->getDescription());
        }
    }
}

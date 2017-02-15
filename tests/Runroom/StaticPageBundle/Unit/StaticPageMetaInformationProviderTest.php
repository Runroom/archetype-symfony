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

        $this->provider = new StaticPageMetaInformationProvider($this->repository->reveal());

        $this->model = $this->prophesize('Runroom\StaticPageBundle\ViewModel\StaticPageViewModel');

        $this->static_page = StaticPageMotherObject::createWithTitleAndContent(self::TITLE, self::CONTENT);

        $this->model->getStaticPage()->willReturn($this->static_page);
    }

    /**
     * @test
     */
    public function itProvidesMetasForStaticPageRoutes()
    {
        $provided_meta_routes = [self::META_ROUTE];

        foreach ($provided_meta_routes as $meta_route) {
            $this->assertTrue($this->provider->providesMetas($meta_route));
        }
    }

    /**
     * @test
     */
    public function itReplacesTitlePlaceholders()
    {
        $placeholders = [
            'Test {title}' => 'Test ' . self::TITLE,
        ];

        foreach ($placeholders as $placeholder => $expected_title) {
            $metas = MetaInformationMotherObject::create($placeholder, '');

            $this->repository->findOneByRoute(self::META_ROUTE)->willReturn($metas);

            $placeholders = $this->provider->findMetasFor(self::META_ROUTE, $this->model->reveal());

            $title = $metas->getTitle();

            $this->assertSame($expected_title, $title);
        }
    }

    /**
     * @test
     */
    public function itReplacesDescriptionPlaceholders()
    {
        $placeholders = [
            'Test {content}' => 'Test ' . self::CONTENT,
        ];

        foreach ($placeholders as $placeholder => $expected_description) {
            $metas = MetaInformationMotherObject::create('', $placeholder);

            $this->repository->findOneByRoute(self::META_ROUTE)->willReturn($metas);

            $placeholders = $this->provider->findMetasFor(self::META_ROUTE, $this->model->reveal());

            $description = $metas->getDescription();

            $this->assertSame($expected_description, $description);
        }
    }
}

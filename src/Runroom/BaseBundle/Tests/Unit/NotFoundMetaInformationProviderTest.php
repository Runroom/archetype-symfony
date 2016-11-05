<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Runroom\BaseBundle\Service\MetaInformationProvider\NotFoundMetaInformationProvider;

class NotFoundMetaInformationProviderTest extends \PHPUnit_Framework_TestCase
{
    const META_ROUTE = '';
    const HOME_ROUTE = 'runroom.runroom.route.home';

    public function setUp()
    {
        $this->repository = $this->prophesize('Runroom\BaseBundle\Repository\MetaInformationRepository');

        $this->provider = new NotFoundMetaInformationProvider(
            $this->repository->reveal()
        );
    }

    /**
     * @test
     */
    public function itProvidesMetasForNotFoundRoute()
    {
        $provided_meta_routes = [self::META_ROUTE];
        $non_provided_meta_routes = ['default', 'runroom.runroom.route.service.services'];

        foreach ($provided_meta_routes as $meta_route) {
            $this->assertTrue($this->provider->providesMetas($meta_route));
        }

        foreach ($non_provided_meta_routes as $meta_route) {
            $this->assertFalse($this->provider->providesMetas($meta_route));
        }
    }

    /**
     * @test
     */
    public function itReturnsHomeMetas()
    {
        $expected_metas = 'metas';
        $model = 'model';

        $this->repository->findOneByRoute(self::HOME_ROUTE)
            ->willReturn($expected_metas);

        $metas = $this->provider->findMetasFor(self::META_ROUTE, $model);

        $this->assertEquals($expected_metas, $metas);
    }
}

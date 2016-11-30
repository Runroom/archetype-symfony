<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Runroom\BaseBundle\Service\MetaInformationProvider\DefaultMetaInformationProvider;

class DefaultMetaInformationProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->repository = $this->prophesize('Runroom\BaseBundle\Repository\MetaInformationRepository');

        $this->provider = new DefaultMetaInformationProvider(
            $this->repository->reveal()
        );
    }

    /**
     * @test
     */
    public function itProvidesMetasForAnyRoute()
    {
        $meta_routes = ['default', 'home'];

        foreach ($meta_routes as $meta_route) {
            $this->assertTrue($this->provider->providesMetas($meta_route));
        }
    }

    /**
     * @test
     */
    public function itFindsMetasForRoute()
    {
        $expected_metas = 'metas';
        $meta_route = 'meta_route';
        $model = 'model';

        $this->repository->findOneByRoute($meta_route)
            ->willReturn($expected_metas);

        $metas = $this->provider->findMetasFor($meta_route, $model);

        $this->assertEquals($expected_metas, $metas);
    }

    /**
     * @test
     */
    public function itFindsDefaultMetasIfRouteWasNotFound()
    {
        $expected_metas = null;
        $expected_default_metas = 'default_metas';
        $meta_route = 'meta_route';
        $default_meta_route = 'default';
        $model = 'model';

        $this->repository->findOneByRoute($meta_route)
            ->willReturn($expected_metas);

        $this->repository->findOneByRoute($default_meta_route)
            ->willReturn($expected_default_metas);

        $metas = $this->provider->findMetasFor($meta_route, $model);

        $this->assertEquals($expected_default_metas, $metas);
    }
}

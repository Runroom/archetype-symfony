<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Service\MetaInformationProvider\DefaultMetaInformationProvider;

class DefaultMetaInformationProviderTest extends TestCase
{
    const DEFAULT_ROUTE = 'default';

    public function setUp()
    {
        $this->repository = $this->prophesize('Runroom\BaseBundle\Repository\MetaInformationRepository');

        $this->provider = new DefaultMetaInformationProvider(
            $this->repository->reveal()
        );

        $this->expected_metas = 'default_metas';
        $this->meta_route = 'meta_route';
        $this->model = 'model';
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
        $this->repository->findOneByRoute($this->meta_route)
            ->willReturn($this->expected_metas);

        $metas = $this->provider->findMetasFor($this->meta_route, $this->model);

        $this->assertEquals($this->expected_metas, $metas);
    }

    /**
     * @test
     */
    public function itFindsDefaultMetasIfRouteWasNotFound()
    {
        $this->repository->findOneByRoute($this->meta_route)
            ->willReturn(null);

        $this->repository->findOneByRoute(self::DEFAULT_ROUTE)
            ->willReturn($this->expected_metas);

        $metas = $this->provider->findMetasFor($this->meta_route, $this->model);

        $this->assertEquals($this->expected_metas, $metas);
    }
}

<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Service\MetaInformationProvider\DefaultMetaInformationProvider;
use Runroom\BaseBundle\Entity\MetaInformation;

class DefaultMetaInformationProviderTest extends TestCase
{
    const DEFAULT_ROUTE = 'default';

    public function setUp()
    {
        $this->repository = $this->prophesize('Runroom\BaseBundle\Repository\MetaInformationRepository');

        $this->provider = new DefaultMetaInformationProvider(
            $this->repository->reveal()
        );

        $this->expectedMetas = new MetaInformation();
    }

    /**
     * @test
     */
    public function itProvidesMetasForAnyRoute()
    {
        $routes = ['default', 'home'];

        foreach ($routes as $route) {
            $this->assertTrue($this->provider->providesMetas($route));
        }
    }

    /**
     * @test
     */
    public function itFindsMetasForRoute()
    {
        $this->repository->findOneByRoute('meta_route')->willReturn($this->expectedMetas);

        $metas = $this->provider->findMetasFor('meta_route', 'model');

        $this->assertSame($this->expectedMetas, $metas);
    }

    /**
     * @test
     */
    public function itFindsDefaultMetasIfRouteWasNotFound()
    {
        $this->repository->findOneByRoute('meta_route')->willReturn(null);
        $this->repository->findOneByRoute(self::DEFAULT_ROUTE)->willReturn($this->expectedMetas);

        $metas = $this->provider->findMetasFor('meta_route', 'model');

        $this->assertSame($this->expectedMetas, $metas);
    }
}

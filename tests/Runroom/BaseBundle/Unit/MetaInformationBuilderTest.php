<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Repository\MetaInformationRepository;
use Runroom\BaseBundle\Service\MetaInformation\AbstractMetaInformationProvider;
use Runroom\BaseBundle\Service\MetaInformation\MetaInformationBuilder;
use Runroom\BaseBundle\ViewModel\MetaInformationViewModel;
use Tests\Runroom\BaseBundle\MotherObject\MetaInformationMotherObject;

class MetaInformationBuilderTest extends TestCase
{
    protected function setUp(): void
    {
        $this->repository = $this->prophesize(MetaInformationRepository::class);
        $this->repository->findOneByRoute(Argument::any())->willReturn(MetaInformationMotherObject::create());

        $this->builder = new MetaInformationBuilder($this->repository->reveal());
    }

    /**
     * @test
     */
    public function itBuildsMetaInformationViewModel()
    {
        $metas = $this->builder->build(
            new TestMetaInformationProvider(),
            'test',
            new \stdClass()
        );

        $this->assertInstanceOf(MetaInformationViewModel::class, $metas);
        $this->assertSame(MetaInformationMotherObject::TITLE, $metas->getTitle());
        $this->assertSame(MetaInformationMotherObject::DESCRIPTION, $metas->getDescription());
        $this->assertNull($metas->getImage());
    }
}

class TestMetaInformationProvider extends AbstractMetaInformationProvider
{
    protected function getRoutes(): array
    {
        return ['test'];
    }

    protected function getRouteAliases(): array
    {
        return [
            'default' => ['test'],
        ];
    }
}

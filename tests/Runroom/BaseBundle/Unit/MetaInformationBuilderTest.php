<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Repository\MetaInformationRepository;
use Runroom\BaseBundle\Service\MetaInformation\AbstractMetaInformationProvider;
use Runroom\BaseBundle\Service\MetaInformation\MetaInformationBuilder;
use Runroom\BaseBundle\ViewModel\MetaInformationViewModel;
use Tests\Runroom\BaseBundle\Fixtures\MetaInformationFixture;

class MetaInformationBuilderTest extends TestCase
{
    protected $repository;
    protected $builder;

    protected function setUp(): void
    {
        $this->repository = $this->prophesize(MetaInformationRepository::class);
        $this->repository->findOneByRoute(Argument::any())->willReturn(MetaInformationFixture::create());

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
        $this->assertSame(MetaInformationFixture::TITLE, $metas->getTitle());
        $this->assertSame(MetaInformationFixture::DESCRIPTION, $metas->getDescription());
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

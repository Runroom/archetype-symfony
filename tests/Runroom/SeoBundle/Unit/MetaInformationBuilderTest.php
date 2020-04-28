<?php

namespace Tests\Runroom\SeoBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Runroom\SeoBundle\MetaInformation\AbstractMetaInformationProvider;
use Runroom\SeoBundle\MetaInformation\MetaInformationBuilder;
use Runroom\SeoBundle\Repository\MetaInformationRepository;
use Runroom\SeoBundle\ViewModel\MetaInformationViewModel;
use Tests\Runroom\SeoBundle\Fixtures\MetaInformationFixture;

class MetaInformationBuilderTest extends TestCase
{
    use ProphecyTrait;

    protected $repository;
    protected $builder;

    protected function setUp(): void
    {
        $this->repository = $this->prophesize(MetaInformationRepository::class);
        $this->repository->findOneBy(Argument::any())->willReturn(MetaInformationFixture::create());

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

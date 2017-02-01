<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Service\MetaInformationService;

class MetaInformationServiceTest extends TestCase
{
    const ROUTE = 'route.es';
    const BASE_ROUTE = 'route';

    public function setUp()
    {
        $this->request_stack = $this->prophesize('Symfony\Component\HttpFoundation\RequestStack');
        $this->provider = $this->prophesize('Runroom\BaseBundle\Service\MetaInformationProvider\AbstractMetaInformationProvider');
        $this->default_provider = $this->prophesize('Runroom\BaseBundle\Service\MetaInformationProvider\AbstractMetaInformationProvider');

        $this->service = new MetaInformationService(
            $this->request_stack->reveal(),
            $this->default_provider->reveal()
        );
        $this->service->addProvider($this->provider->reveal());

        $this->model = 'model';
    }

    /**
     * @before
     */
    public function onPageEvent()
    {
        $this->page = $this->prophesize('Runroom\BaseBundle\ViewModel\PageViewModel');
        $this->event = $this->prophesize('Runroom\BaseBundle\Event\PageEvent');
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request');

        $this->request_stack->getCurrentRequest()
            ->willReturn($request->reveal());

        $request->get('_route')
            ->willReturn(self::ROUTE);

        $this->event->getPage()
            ->willReturn($this->page->reveal());

        $this->page->getContent()
            ->willReturn($this->model);
    }

    /**
     * @test
     */
    public function itFindsMetasForRoute()
    {
        $expected_metas = 'metas';

        $this->provider->providesMetas(self::BASE_ROUTE)
            ->willReturn(true);

        $this->provider->findMetasFor(self::BASE_ROUTE, $this->model)
            ->willReturn($expected_metas);

        $this->metas = $this->service->findMetasFor(self::ROUTE, $this->model);

        $this->assertEquals($expected_metas, $this->metas);
    }

    /**
     * @test
     */
    public function itReturnsDefaultProviderMetasIfNoOtherProviderRespond()
    {
        $expected_metas = 'metas';

        $this->provider->providesMetas(self::BASE_ROUTE)
            ->willReturn(false);

        $this->default_provider->findMetasFor(self::BASE_ROUTE, $this->model)
            ->willReturn($expected_metas);

        $this->metas = $this->service->findMetasFor(self::ROUTE, $this->model);

        $this->assertEquals($expected_metas, $this->metas);
    }

    /**
     * @after
     */
    public function setMetasOnPage()
    {
        $this->page->setMetas($this->metas)
            ->shouldBeCalled();

        $this->event->setPage($this->page->reveal())
            ->shouldBeCalled();

        $this->service->onPageEvent($this->event->reveal());
    }
}

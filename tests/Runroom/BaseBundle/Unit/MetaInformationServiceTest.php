<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Entity\MetaInformation;
use Runroom\BaseBundle\Service\MetaInformationService;

class MetaInformationServiceTest extends TestCase
{
    const ROUTE = 'route.es';
    const BASE_ROUTE = 'route';

    public function setUp()
    {
        $this->requestStack = $this->prophesize('Symfony\Component\HttpFoundation\RequestStack');
        $this->provider = $this->prophesize('Runroom\BaseBundle\Service\MetaInformationProvider\AbstractMetaInformationProvider');
        $this->defaultProvider = $this->prophesize('Runroom\BaseBundle\Service\MetaInformationProvider\AbstractMetaInformationProvider');

        $this->service = new MetaInformationService(
            $this->requestStack->reveal(),
            $this->defaultProvider->reveal()
        );
        $this->service->addProvider($this->provider->reveal());

        $this->model = 'model';
        $this->expectedMetas = new MetaInformation();
    }

    /**
     * @before
     */
    public function onPageEvent()
    {
        $this->page = $this->prophesize('Runroom\BaseBundle\ViewModel\PageViewModel');
        $this->event = $this->prophesize('Runroom\BaseBundle\Event\PageEvent');
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request');

        $this->requestStack->getCurrentRequest()->willReturn($request->reveal());
        $request->get('_route')->willReturn(self::ROUTE);
        $this->event->getPage()->willReturn($this->page->reveal());
        $this->page->getContent()->willReturn($this->model);
    }

    /**
     * @test
     */
    public function itFindsMetasForRoute()
    {
        $this->provider->providesMetas(self::BASE_ROUTE)->willReturn(true);
        $this->provider->findMetasFor(self::BASE_ROUTE, $this->model)->willReturn($this->expectedMetas);

        $this->metas = $this->service->findMetasFor(self::ROUTE, $this->model);

        $this->assertSame($this->expectedMetas, $this->metas);
    }

    /**
     * @test
     */
    public function itReturnsDefaultProviderMetasIfNoOtherProviderRespond()
    {
        $this->provider->providesMetas(self::BASE_ROUTE)->willReturn(false);
        $this->defaultProvider->findMetasFor(self::BASE_ROUTE, $this->model)->willReturn($this->expectedMetas);

        $this->metas = $this->service->findMetasFor(self::ROUTE, $this->model);

        $this->assertSame($this->expectedMetas, $this->metas);
    }

    /**
     * @after
     */
    public function setMetasOnPage()
    {
        $this->page->setMetas($this->metas)->shouldBeCalled();
        $this->event->setPage($this->page->reveal())->shouldBeCalled();

        $this->service->onPageEvent($this->event->reveal());
    }
}

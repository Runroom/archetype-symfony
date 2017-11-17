<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Entity\MetaInformation;
use Runroom\BaseBundle\Event\PageEvent;
use Runroom\BaseBundle\Service\MetaInformationProvider\AbstractMetaInformationProvider;
use Runroom\BaseBundle\Service\MetaInformationProvider\DefaultMetaInformationProvider;
use Runroom\BaseBundle\Service\MetaInformationService;
use Runroom\BaseBundle\ViewModel\PageViewModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class MetaInformationServiceTest extends TestCase
{
    const ROUTE = 'route.es';
    const BASE_ROUTE = 'route';

    protected function setUp()
    {
        $this->requestStack = $this->prophesize(RequestStack::class);
        $this->provider = $this->prophesize(AbstractMetaInformationProvider::class);
        $this->defaultProvider = $this->prophesize(DefaultMetaInformationProvider::class);

        $this->service = new MetaInformationService(
            $this->requestStack->reveal(),
            [$this->provider->reveal()],
            $this->defaultProvider->reveal()
        );

        $this->model = 'model';
        $this->expectedMetas = new MetaInformation();

        $this->configureOnPageEvent();
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

    private function configureOnPageEvent()
    {
        $this->page = $this->prophesize(PageViewModel::class);
        $this->event = $this->prophesize(PageEvent::class);
        $request = $this->prophesize(Request::class);

        $this->requestStack->getCurrentRequest()->willReturn($request->reveal());
        $request->get('_route', '')->willReturn(self::ROUTE);
        $this->event->getPage()->willReturn($this->page->reveal());
        $this->page->getContent()->willReturn($this->model);
    }
}

<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Event\PageRenderEvent;
use Runroom\BaseBundle\Service\MetaInformation\AbstractMetaInformationProvider;
use Runroom\BaseBundle\Service\MetaInformation\DefaultMetaInformationProvider;
use Runroom\BaseBundle\Service\MetaInformation\MetaInformationBuilder;
use Runroom\BaseBundle\Service\MetaInformation\MetaInformationService;
use Runroom\BaseBundle\ViewModel\MetaInformationViewModel;
use Runroom\BaseBundle\ViewModel\PageViewModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class MetaInformationServiceTest extends TestCase
{
    const ROUTE = 'route.es';
    const BASE_ROUTE = 'route';

    protected $requestStack;
    protected $provider;
    protected $defaultProvider;
    protected $builder;
    protected $model;
    protected $service;
    protected $expectedMetas;

    protected function setUp(): void
    {
        $this->requestStack = $this->prophesize(RequestStack::class);
        $this->provider = $this->prophesize(AbstractMetaInformationProvider::class);
        $this->defaultProvider = $this->prophesize(DefaultMetaInformationProvider::class);
        $this->builder = $this->prophesize(MetaInformationBuilder::class);

        $this->provider->providesMetas(Argument::any())->willReturn(false);
        $this->defaultProvider->providesMetas(Argument::any())->willReturn(true);

        $this->service = new MetaInformationService(
            $this->requestStack->reveal(),
            [$this->provider->reveal()],
            $this->defaultProvider->reveal(),
            $this->builder->reveal()
        );

        $this->model = new \stdClass();
        $this->expectedMetas = new MetaInformationViewModel();
    }

    /**
     * @test
     */
    public function itFindsMetasForRoute()
    {
        $this->configureCurrentRequest();
        $this->provider->providesMetas(self::BASE_ROUTE)->willReturn(true);
        $this->builder->build($this->provider->reveal(), self::BASE_ROUTE, $this->model)
            ->willReturn($this->expectedMetas);

        $event = $this->configurePageRenderEvent();
        $this->service->onPageRender($event);

        $this->assertSame($this->expectedMetas, $event->getPageViewModel()->getMetas());
    }

    /**
     * @test
     */
    public function itFindsMetasForRouteWithTheDefaultProvider()
    {
        $this->configureCurrentRequest();
        $this->builder->build($this->defaultProvider->reveal(), self::BASE_ROUTE, $this->model)
            ->willReturn($this->expectedMetas);

        $event = $this->configurePageRenderEvent();
        $this->service->onPageRender($event);

        $this->assertSame($this->expectedMetas, $event->getPageViewModel()->getMetas());
    }

    /**
     * @test
     */
    public function itHasSubscribedEvents()
    {
        $events = $this->service->getSubscribedEvents();
        $this->assertNotNull($events);
    }

    protected function configurePageRenderEvent(): PageRenderEvent
    {
        $response = $this->prophesize(Response::class);
        $page = new PageViewModel();
        $page->setContent($this->model);

        return new PageRenderEvent('view', $page, $response->reveal());
    }

    protected function configureCurrentRequest(): void
    {
        $request = $this->prophesize(Request::class);
        $this->requestStack->getCurrentRequest()->willReturn($request->reveal());
        $request->get('_route', '')->willReturn(self::ROUTE);
    }
}

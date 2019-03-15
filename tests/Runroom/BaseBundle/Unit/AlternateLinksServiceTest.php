<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Event\PageRenderEvent;
use Runroom\BaseBundle\Service\AlternateLinks\AbstractAlternateLinksProvider;
use Runroom\BaseBundle\Service\AlternateLinks\AlternateLinksBuilder;
use Runroom\BaseBundle\Service\AlternateLinks\AlternateLinksService;
use Runroom\BaseBundle\Service\AlternateLinks\DefaultAlternateLinksProvider;
use Runroom\BaseBundle\ViewModel\PageViewModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class AlternateLinksServiceTest extends TestCase
{
    const ROUTE = 'route.es';
    const BASE_ROUTE = 'route';

    protected function setUp(): void
    {
        $this->requestStack = $this->prophesize(RequestStack::class);
        $this->provider = $this->prophesize(AbstractAlternateLinksProvider::class);
        $this->defaultProvider = $this->prophesize(DefaultAlternateLinksProvider::class);
        $this->builder = $this->prophesize(AlternateLinksBuilder::class);

        $this->service = new AlternateLinksService(
            $this->requestStack->reveal(),
            [$this->provider->reveal()],
            $this->defaultProvider->reveal(),
            $this->builder->reveal()
        );
    }

    /**
     * @test
     */
    public function itFindsAlternateLinksForRoute()
    {
        $this->configureCurrentRequest();
        $this->provider->providesAlternateLinks(self::BASE_ROUTE)->willReturn(true);
        $this->builder->build($this->provider->reveal(), self::BASE_ROUTE, 'model')->willReturn(['alternate_links']);

        $event = $this->configurePageRenderEvent();
        $this->service->onPageRender($event);

        $this->assertSame(['alternate_links'], $event->getPageViewModel()->getAlternateLinks());
    }

    /**
     * @test
     */
    public function itFindsAlternateLinksForRouteWithTheDefaultProvider()
    {
        $this->configureCurrentRequest();
        $this->provider->providesAlternateLinks(self::BASE_ROUTE)->willReturn(false);
        $this->builder->build($this->defaultProvider->reveal(), self::BASE_ROUTE, 'model')->willReturn(['alternate_links']);

        $event = $this->configurePageRenderEvent();
        $this->service->onPageRender($event);

        $this->assertSame(['alternate_links'], $event->getPageViewModel()->getAlternateLinks());
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
        $page->setContent('model');

        return new PageRenderEvent('view', $page, $response->reveal());
    }

    protected function configureCurrentRequest(): void
    {
        $request = $this->prophesize(Request::class);
        $this->requestStack->getCurrentRequest()->willReturn($request->reveal());
        $request->get('_route', '')->willReturn(self::ROUTE);
    }
}

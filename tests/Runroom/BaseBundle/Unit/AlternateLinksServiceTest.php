<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Service\AlternateLinks\AbstractAlternateLinksProvider;
use Runroom\BaseBundle\Service\AlternateLinks\AlternateLinksBuilder;
use Runroom\BaseBundle\Service\AlternateLinks\AlternateLinksService;
use Runroom\BaseBundle\Service\AlternateLinks\DefaultAlternateLinksProvider;
use Runroom\BaseBundle\ViewModel\PageViewModel;
use Runroom\RenderEventBundle\Event\PageRenderEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class AlternateLinksServiceTest extends TestCase
{
    protected const ROUTE = 'route';

    protected $requestStack;
    protected $provider;
    protected $defaultProvider;
    protected $builder;
    protected $service;

    protected function setUp(): void
    {
        $this->requestStack = new RequestStack();
        $this->provider = $this->prophesize(AbstractAlternateLinksProvider::class);
        $this->defaultProvider = $this->prophesize(DefaultAlternateLinksProvider::class);
        $this->builder = $this->prophesize(AlternateLinksBuilder::class);

        $this->service = new AlternateLinksService(
            $this->requestStack,
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

        $this->provider->providesAlternateLinks(self::ROUTE)->willReturn(true);
        $this->builder->build($this->provider->reveal(), 'model', self::ROUTE, [])->willReturn(['alternate_links']);

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

        $this->provider->providesAlternateLinks(self::ROUTE)->willReturn(false);
        $this->builder->build($this->defaultProvider->reveal(), 'model', self::ROUTE, [])->willReturn(['alternate_links']);

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
        $response = new Response();
        $page = new PageViewModel();
        $page->setContent('model');

        return new PageRenderEvent('view', $page, $response);
    }

    protected function configureCurrentRequest(): void
    {
        $request = new Request();

        $this->requestStack->push($request);

        $request->attributes->set('_route', self::ROUTE);
    }
}

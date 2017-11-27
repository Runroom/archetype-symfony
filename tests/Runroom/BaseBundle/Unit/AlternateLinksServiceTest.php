<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Event\PageRenderEvent;
use Runroom\BaseBundle\Service\AlternateLinksProvider\AbstractAlternateLinksProvider;
use Runroom\BaseBundle\Service\AlternateLinksProvider\DefaultAlternateLinksProvider;
use Runroom\BaseBundle\Service\AlternateLinksService;
use Runroom\BaseBundle\ViewModel\PageViewModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class AlternateLinksServiceTest extends TestCase
{
    const ROUTE = 'route.es';
    const BASE_ROUTE = 'route';

    protected function setUp()
    {
        $this->requestStack = $this->prophesize(RequestStack::class);
        $this->provider = $this->prophesize(AbstractAlternateLinksProvider::class);
        $this->defaultProvider = $this->prophesize(DefaultAlternateLinksProvider::class);

        $this->service = new AlternateLinksService(
            $this->requestStack->reveal(),
            [$this->provider->reveal()],
            $this->defaultProvider->reveal()
        );

        $this->configureOnPageRenderEvent();
    }

    /**
     * @test
     */
    public function itFindsAlternateLinksForRoute()
    {
        $this->provider->providesAlternateLinks(self::BASE_ROUTE)->willReturn(true);
        $this->provider->findAlternateLinksFor(self::BASE_ROUTE, 'model')->willReturn(['alternate_links']);

        $this->alternateLinks = $this->service->findAlternateLinksFor(self::ROUTE, 'model');

        $this->assertSame(['alternate_links'], $this->alternateLinks);
    }

    /**
     * @test
     */
    public function itReturnsDefaultProviderAlternateLinksIfNoOtherProviderRespond()
    {
        $this->provider->providesAlternateLinks(self::BASE_ROUTE)->willReturn(false);
        $this->defaultProvider->findAlternateLinksFor(self::BASE_ROUTE, 'model')->willReturn(['alternate_links']);

        $this->alternateLinks = $this->service->findAlternateLinksFor(self::ROUTE, 'model');

        $this->assertSame(['alternate_links'], $this->alternateLinks);
    }

    /**
     * @after
     */
    public function setAlternateLinksOnPage()
    {
        $this->page->setAlternateLinks($this->alternateLinks)->shouldBeCalled();
        $this->event->setPage($this->page->reveal())->shouldBeCalled();

        $this->service->onPageRender($this->event->reveal());
    }

    private function configureOnPageRenderEvent()
    {
        $this->page = $this->prophesize(PageViewModel::class);
        $this->event = $this->prophesize(PageRenderEvent::class);
        $request = $this->prophesize(Request::class);

        $this->requestStack->getCurrentRequest()->willReturn($request->reveal());
        $request->get('_route', '')->willReturn(self::ROUTE);
        $this->event->getPage()->willReturn($this->page->reveal());
        $this->page->getContent()->willReturn('model');
    }
}

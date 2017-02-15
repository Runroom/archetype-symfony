<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Service\AlternateLinksService;

class AlternateLinksServiceTest extends TestCase
{
    const ROUTE = 'route.es';
    const BASE_ROUTE = 'route';

    public function setUp()
    {
        $this->request_stack = $this->prophesize('Symfony\Component\HttpFoundation\RequestStack');
        $this->provider = $this->prophesize('Runroom\BaseBundle\Service\AlternateLinksProvider\AbstractAlternateLinksProvider');
        $this->default_provider = $this->prophesize('Runroom\BaseBundle\Service\AlternateLinksProvider\AbstractAlternateLinksProvider');

        $this->service = new AlternateLinksService(
            $this->request_stack->reveal(),
            $this->default_provider->reveal()
        );
        $this->service->addProvider($this->provider->reveal());
    }

    /**
     * @before
     */
    public function onPageEvent()
    {
        $this->page = $this->prophesize('Runroom\BaseBundle\ViewModel\PageViewModel');
        $this->event = $this->prophesize('Runroom\BaseBundle\Event\PageEvent');
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request');

        $this->request_stack->getCurrentRequest()->willReturn($request->reveal());
        $request->get('_route')->willReturn(self::ROUTE);
        $this->event->getPage()->willReturn($this->page->reveal());
        $this->page->getContent()->willReturn('model');
    }

    /**
     * @test
     */
    public function itFindsAlternateLinksForRoute()
    {
        $this->provider->providesAlternateLinks(self::BASE_ROUTE)->willReturn(true);
        $this->provider->findAlternateLinksFor(self::BASE_ROUTE, 'model')->willReturn('alternate_links');

        $this->alternate_links = $this->service->findAlternateLinksFor(self::ROUTE, 'model');

        $this->assertSame('alternate_links', $this->alternate_links);
    }

    /**
     * @test
     */
    public function itReturnsDefaultProviderAlternateLinksIfNoOtherProviderRespond()
    {
        $this->provider->providesAlternateLinks(self::BASE_ROUTE)->willReturn(false);
        $this->default_provider->findAlternateLinksFor(self::BASE_ROUTE, 'model')->willReturn('alternate_links');

        $this->alternate_links = $this->service->findAlternateLinksFor(self::ROUTE, 'model');

        $this->assertSame('alternate_links', $this->alternate_links);
    }

    /**
     * @after
     */
    public function setAlternateLinksOnPage()
    {
        $this->page->setAlternateLinks($this->alternate_links)->shouldBeCalled();
        $this->event->setPage($this->page->reveal())->shouldBeCalled();

        $this->service->onPageEvent($this->event->reveal());
    }
}

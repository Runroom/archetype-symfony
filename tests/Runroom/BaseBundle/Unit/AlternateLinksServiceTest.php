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
    public function itFindsAlternateLinksForRoute()
    {
        $expected_alternate = 'alternate_links';

        $this->provider->providesAlternateLinks(self::BASE_ROUTE)
            ->willReturn(true);

        $this->provider->findAlternateLinksFor(self::BASE_ROUTE, $this->model)
            ->willReturn($expected_alternate);

        $this->alternate_links = $this->service->findAlternateLinksFor(self::ROUTE, $this->model);

        $this->assertEquals($expected_alternate, $this->alternate_links);
    }

    /**
     * @test
     */
    public function itReturnsDefaultProviderAlternateLinksIfNoOtherProviderRespond()
    {
        $expected_alternate = 'alternate_links';

        $this->provider->providesAlternateLinks(self::BASE_ROUTE)
            ->willReturn(false);

        $this->default_provider->findAlternateLinksFor(self::BASE_ROUTE, $this->model)
            ->willReturn($expected_alternate);

        $this->alternate_links = $this->service->findAlternateLinksFor(self::ROUTE, $this->model);

        $this->assertEquals($expected_alternate, $this->alternate_links);
    }

    /**
     * @after
     */
    public function setAlternateLinksOnPage()
    {
        $this->page->setAlternateLinks($this->alternate_links)
            ->shouldBeCalled();

        $this->event->setPage($this->page->reveal())
            ->shouldBeCalled();

        $this->service->onPageEvent($this->event->reveal());
    }
}

<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Runroom\BaseBundle\Service\AlternateLinksService;

class AlternateLinksServiceTest extends \PHPUnit_Framework_TestCase
{
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

        $this->route = 'route.es';
        $this->expected_base_route = 'route';
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
            ->willReturn($this->route);

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
        $expected_alternate_links = 'alternate_links';

        $this->provider->providesAlternateLinks($this->expected_base_route)
            ->willReturn(true);

        $this->provider->findAlternateLinksFor($this->expected_base_route, $this->model)
            ->willReturn($expected_alternate_links);

        $this->alternate_links = $this->service->findAlternateLinksFor($this->route, $this->model);

        $this->assertEquals($expected_alternate_links, $this->alternate_links);
    }

    /**
     * @test
     */
    public function itReturnsDefaultProviderAlternateLinksIfNoOtherProviderRespond()
    {
        $expected_alternate_links = 'alternate_links';

        $this->provider->providesAlternateLinks($this->expected_base_route)
            ->willReturn(false);

        $this->default_provider->findAlternateLinksFor($this->expected_base_route, $this->model)
            ->willReturn($expected_alternate_links);

        $this->alternate_links = $this->service->findAlternateLinksFor($this->route, $this->model);

        $this->assertEquals($expected_alternate_links, $this->alternate_links);
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

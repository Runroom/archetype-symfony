<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Runroom\BaseBundle\Service\MetaInformationService;

class MetaInformationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->request_stack = $this->prophesize('Symfony\Component\HttpFoundation\RequestStack');
        $this->provider = $this->prophesize('Runroom\BaseBundle\Service\MetaInformationProvider\AbstractMetaInformationProvider');

        $this->service = new MetaInformationService($this->request_stack->reveal());
        $this->service->addProvider($this->provider->reveal());

        $this->route = 'route.es';
        $this->expected_meta_route = 'route';
        $this->model = 'model';
    }

    /**
     * @before
     */
    public function onPageEvent()
    {
        $expected_model = 'model';
        $expected_metas = 'metas';

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
    public function itFindsMetasForRoute()
    {
        $expected_metas = 'metas';

        $this->provider->providesMetas($this->expected_meta_route)
            ->willReturn(true);

        $this->provider->findMetasFor($this->expected_meta_route, $this->model)
            ->willReturn($expected_metas);

        $this->metas = $this->service->findMetasFor($this->route, $this->model);

        $this->assertEquals($expected_metas, $this->metas);
    }

    /**
     * @test
     */
    public function itReturnsNullIfNoProviderWasFound()
    {
        $this->provider->providesMetas($this->expected_meta_route)
            ->willReturn(false);

        $this->metas = $this->service->findMetasFor($this->route, $this->model);

        $this->assertNull($this->metas);
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

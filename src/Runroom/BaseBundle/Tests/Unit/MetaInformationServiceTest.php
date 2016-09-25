<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Runroom\BaseBundle\Service\MetaInformationService;

class MetaInformationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->test_provider = $this->prophesize('Runroom\BaseBundle\Service\MetaInformationProvider\AbstractMetaInformationProvider');

        $this->providers = [$this->test_provider->reveal()];

        $this->request_stack = $this->prophesize('Symfony\Component\HttpFoundation\RequestStack');

        $this->service = new MetaInformationService(
            $this->providers,
            $this->request_stack->reveal()
        );

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

        $this->test_provider->providesMetas($this->expected_meta_route)
            ->willReturn(true);

        $this->test_provider->findMetasFor($this->expected_meta_route, $this->model)
            ->willReturn($expected_metas);

        $this->metas = $this->service->findMetasFor($this->route, $this->model);

        $this->assertEquals($expected_metas, $this->metas);
    }

    /**
     * @test
     */
    public function itReturnsNullIfNoProviderWasFound()
    {
        $this->test_provider->providesMetas($this->expected_meta_route)
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


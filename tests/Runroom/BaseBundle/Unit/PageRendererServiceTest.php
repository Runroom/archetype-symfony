<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Service\PageRendererService;
use Runroom\BaseBundle\ViewModel\PageViewModel;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;

class PageRendererServiceTest extends TestCase
{
    protected function setUp()
    {
        $this->renderer = $this->prophesize(EngineInterface::class);
        $this->eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->pageViewModel = $this->prophesize(PageViewModel::class);

        $this->service = new PageRendererService(
            $this->renderer->reveal(),
            $this->eventDispatcher->reveal(),
            $this->pageViewModel->reveal()
        );
    }

    /**
     * @test
     */
    public function itDispatchEventsOnRenderResponse()
    {
        $expectedResponse = $this->prophesize(Response::class);

        $this->renderer->renderResponse('test.html.twig', Argument::type('array'), null)
            ->willReturn($expectedResponse->reveal());

        $response = $this->service->renderResponse('test.html.twig', []);

        $this->assertSame($expectedResponse->reveal(), $response);
    }
}

<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Service\PageRendererService;

class PageRendererServiceTest extends TestCase
{
    public function setUp()
    {
        $this->renderer = $this->prophesize('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');
        $this->pageViewModel = $this->prophesize('Runroom\BaseBundle\ViewModel\PageViewModel');
        $this->eventDispatcher = $this->prophesize('Symfony\Component\EventDispatcher\EventDispatcherInterface');

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
        $expectedResponse = $this->prophesize('Symfony\Component\HttpFoundation\Response');

        $this->renderer->renderResponse('test.html.twig', Argument::type('array'), null)
            ->willReturn($expectedResponse->reveal());

        $response = $this->service->renderResponse('test.html.twig', []);

        $this->assertSame($expectedResponse->reveal(), $response);
    }
}

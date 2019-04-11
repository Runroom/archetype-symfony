<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Service\PageRendererService;
use Runroom\BaseBundle\ViewModel\PageViewModel;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class PageRendererServiceTest extends TestCase
{
    protected $twig;
    protected $eventDispatcher;
    protected $pageViewModel;
    protected $service;

    protected function setUp(): void
    {
        $this->twig = $this->prophesize(Environment::class);
        $this->eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->pageViewModel = $this->prophesize(PageViewModel::class);

        $this->service = new PageRendererService(
            $this->twig->reveal(),
            $this->eventDispatcher->reveal(),
            $this->pageViewModel->reveal()
        );
    }

    /**
     * @test
     */
    public function itDispatchEventsOnRenderResponse()
    {
        $response = $this->prophesize(Response::class);

        $this->pageViewModel->setContent([])->shouldBeCalled();
        $this->twig->render('test.html.twig', Argument::type('array'), null)
            ->willReturn('Rendered test');
        $this->eventDispatcher->dispatch(Argument::any());
        $response->getContent()->willReturn('');
        $response->setContent('Rendered test')->willReturn($response->reveal());

        $resultResponse = $this->service->renderResponse('test.html.twig', [], $response->reveal());

        $this->assertSame($response->reveal(), $resultResponse);
    }
}

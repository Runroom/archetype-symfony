<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Event\PageRenderEvent;
use Runroom\BaseBundle\ViewModel\PageViewModel;
use Symfony\Component\HttpFoundation\Response;

class PageRenderEventTest extends TestCase
{
    protected function setUp(): void
    {
        $this->pageViewModel = $this->prophesize(PageViewModel::class);
        $this->response = $this->prophesize(Response::class);

        $this->pageRenderEvent = new PageRenderEvent(
            'view',
            $this->pageViewModel->reveal(),
            $this->response->reveal()
        );
    }

    /**
     * @test
     */
    public function itSetsPageViewModel()
    {
        $expectedViewModel = new PageViewModel();

        $this->pageRenderEvent->setPageViewModel($expectedViewModel);

        $viewModel = $this->pageRenderEvent->getPageViewModel();

        $this->assertSame($expectedViewModel, $viewModel);
    }

    /**
     * @test
     */
    public function itGetsPageViewModel()
    {
        $this->pageViewModel->getContent()->willReturn('model');

        $viewModel = $this->pageRenderEvent->getPageViewModel();

        $this->assertInstanceOf(PageViewModel::class, $viewModel);
        $this->assertSame('model', $viewModel->getContent());
    }
}

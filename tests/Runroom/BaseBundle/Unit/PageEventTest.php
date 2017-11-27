<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Event\PageRenderEvent;
use Runroom\BaseBundle\ViewModel\PageViewModel;

class PageRenderEventTest extends TestCase
{
    protected function setUp()
    {
        $this->pageViewModel = $this->prophesize('Runroom\BaseBundle\ViewModel\PageViewModel');
        $this->pageRenderEvent = new PageRenderEvent(
            $this->pageViewModel->reveal()
        );
    }

    /**
     * @test
     */
    public function itSetsPage()
    {
        $expectedViewModel = new PageViewModel();

        $this->pageRenderEvent->setPage($expectedViewModel);

        $viewModel = $this->pageRenderEvent->getPage();

        $this->assertSame($expectedViewModel, $viewModel);
    }

    /**
     * @test
     */
    public function itGetsPage()
    {
        $this->pageViewModel
            ->getContent()
            ->shouldBeCalled()
            ->willReturn('model');

        $viewModel = $this->pageRenderEvent->getPage();

        $this->assertInstanceOf(PageViewModel::class, $viewModel);
        $this->assertSame('model', $viewModel->getContent());
    }
}

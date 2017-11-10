<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Event\PageEvent;
use Runroom\BaseBundle\ViewModel\PageViewModel;

class PageEventTest extends TestCase
{
    protected function setUp()
    {
        $this->pageViewModel = $this->prophesize('Runroom\BaseBundle\ViewModel\PageViewModel');
        $this->pageEvent = new PageEvent(
            $this->pageViewModel->reveal()
        );
    }

    /**
     * @test
     */
    public function itSetsPage()
    {
        $expectedViewModel = new PageViewModel();

        $this->pageEvent->setPage($expectedViewModel);

        $viewModel = $this->pageEvent->getPage();

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

        $viewModel = $this->pageEvent->getPage();

        $this->assertInstanceOf(PageViewModel::class, $viewModel);
        $this->assertSame('model', $viewModel->getContent());
    }
}

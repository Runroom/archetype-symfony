<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Event\PageEvent;
use Runroom\BaseBundle\ViewModel\PageViewModel;

class PageEventTest extends TestCase
{
    public function setUp()
    {
        $this->pageEvent = new PageEvent('model');
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
        $viewModel = $this->pageEvent->getPage();

        $this->assertInstanceOf('Runroom\BaseBundle\ViewModel\PageViewModel', $viewModel);
        $this->assertSame('model', $viewModel->getContent());
    }
}

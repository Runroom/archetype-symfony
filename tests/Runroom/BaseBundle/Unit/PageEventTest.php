<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Event\PageEvent;
use Runroom\BaseBundle\ViewModel\PageViewModel;

class PageEventTest extends TestCase
{
    public function setUp()
    {
        $this->page_event = new PageEvent('model');
    }

    /**
     * @test
     */
    public function itSetsPage()
    {
        $expected_view_model = new PageViewModel();

        $this->page_event->setPage($expected_view_model);

        $page_view_model = $this->page_event->getPage();

        $this->assertSame($expected_view_model, $page_view_model);
    }

    /**
     * @test
     */
    public function itGetsPage()
    {
        $page_view_model = $this->page_event->getPage();

        $this->assertInstanceOf('Runroom\BaseBundle\ViewModel\PageViewModel', $page_view_model);
        $this->assertSame('model', $page_view_model->getContent());
    }
}

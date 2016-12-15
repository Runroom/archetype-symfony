<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Runroom\BaseBundle\Event\PageEvent;
use Runroom\BaseBundle\ViewModel\PageViewModel;

class PageEventTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->model = 'model';

        $this->page_event = new PageEvent($this->model);
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
        $this->assertSame($this->model, $page_view_model->getContent());
    }
}

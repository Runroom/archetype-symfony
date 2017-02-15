<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Controller\BaseController;

class BaseControllerTest extends TestCase
{
    public function setUp()
    {
        $this->renderer = $this->prophesize('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');
        $this->event_dispatcher = $this->prophesize('Symfony\Component\EventDispatcher\EventDispatcherInterface');

        $this->controller = new TestController($this->renderer->reveal());
        $this->controller->setEventDispatcher($this->event_dispatcher->reveal());
    }

    /**
     * @test
     */
    public function itDispatchEventsOnRenderResponse()
    {
        $this->renderer->renderResponse('test.html.twig', Argument::type('array'), null)
            ->willReturn('response');

        $response = $this->controller->renderSomething();

        $this->assertSame('response', $response);
    }
}

class TestController extends BaseController
{
    public function renderSomething()
    {
        return $this->renderResponse('test.html.twig');
    }
}

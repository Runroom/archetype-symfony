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
        $this->eventDispatcher = $this->prophesize('Symfony\Component\EventDispatcher\EventDispatcherInterface');

        $this->controller = new TestController($this->renderer->reveal());
        $this->controller->setEventDispatcher($this->eventDispatcher->reveal());
    }

    /**
     * @test
     */
    public function itDispatchEventsOnRenderResponse()
    {
        $expectedResponse = $this->prophesize('Symfony\Component\HttpFoundation\Response');

        $this->renderer->renderResponse('test.html.twig', Argument::type('array'), null)
            ->willReturn($expectedResponse->reveal());

        $response = $this->controller->renderSomething();

        $this->assertSame($expectedResponse->reveal(), $response);
    }
}

class TestController extends BaseController
{
    public function renderSomething()
    {
        return $this->renderResponse('test.html.twig');
    }
}

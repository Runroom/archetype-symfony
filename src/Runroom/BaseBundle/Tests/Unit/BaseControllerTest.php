<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Runroom\BaseBundle\Controller\BaseController;
use Prophecy\Argument;

class BaseControllerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->renderer = $this->prophesize('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');
        $this->event_dispatcher = $this->prophesize('Symfony\Component\EventDispatcher\EventDispatcherInterface');

        $this->controller = new TestController(
            $this->renderer->reveal()
        );

        $this->controller->setEventDispatcher(
            $this->event_dispatcher->reveal()
        );
    }

    /**
     * @test
     */
    public function itDispatchEventsOnRenderResponse()
    {
        $expected_response = 'response';

        $this->renderer->renderResponse(TestController::TEMPLATE, Argument::type('array'), null)
            ->willReturn($expected_response);

        $response = $this->controller->renderSomething();
    }
}

class TestController extends BaseController
{
    const TEMPLATE = 'test.html.twig';

    public function renderSomething()
    {
        return $this->renderResponse(self::TEMPLATE);
    }
}

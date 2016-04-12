<?php

namespace Runroom\DemoBundle\Tests\Unit;

use Runroom\DemoBundle\Controller\DemoController;

class DemoControllerTest extends \PHPUnit_Framework_TestCase
{
    const INDEX_VIEW = 'demo/index.html.twig';

    public function setUp()
    {
        $this->renderer = $this->prophesize('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');
        $this->controller = new DemoController($this->renderer->reveal());
    }

    /**
     * @test
     */
    public function renderIndex()
    {
        $expected_response = new \stdClass();
        $this->renderer->renderResponse(self::INDEX_VIEW, [])
            ->willReturn($expected_response);
        $response = $this->controller->index();

        $this->assertSame($expected_response, $response);
    }
}

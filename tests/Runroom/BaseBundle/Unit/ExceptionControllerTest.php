<?php

namespace Tests\Runroom\BaseBundle\Unit;

use Prophecy\Argument;
use Runroom\BaseBundle\Controller\ExceptionController;

class ExceptionControllerTest extends \PHPUnit_Framework_TestCase
{
    const NOT_FOUND = 'pages/404.html.twig';

    public function setUp()
    {
        $this->renderer = $this->prophesize('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');

        $this->controller = new ExceptionController(
            $this->renderer->reveal()
        );
    }

    /**
     * @test
     */
    public function itRenders404()
    {
        $expected_response = 'response';

        $this->renderer->renderResponse(
            self::NOT_FOUND,
            Argument::type('array'),
            Argument::type('Symfony\Component\HttpFoundation\Response')
        )->willReturn($expected_response);

        $response = $this->controller->notFound();

        $this->assertSame($expected_response, $response);
    }
}

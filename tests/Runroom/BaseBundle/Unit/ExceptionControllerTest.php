<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Controller\ExceptionController;

class ExceptionControllerTest extends TestCase
{
    const NOT_FOUND = 'pages/404.html.twig';

    public function setUp()
    {
        $this->renderer = $this->prophesize('Runroom\BaseBundle\Service\PageRendererService');

        $this->controller = new ExceptionController($this->renderer->reveal());
    }

    /**
     * @test
     */
    public function itRenders404()
    {
        $expectedResponse = $this->prophesize('Symfony\Component\HttpFoundation\Response');

        $this->renderer->renderResponse(
            self::NOT_FOUND,
            null,
            Argument::type('Symfony\Component\HttpFoundation\Response')
        )->willReturn($expectedResponse->reveal());

        $response = $this->controller->notFound();

        $this->assertSame($expectedResponse->reveal(), $response);
    }
}

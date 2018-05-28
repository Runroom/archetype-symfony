<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Controller\ExceptionController;
use Runroom\BaseBundle\Service\PageRendererService;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;

class ExceptionControllerTest extends TestCase
{
    const NOT_FOUND = 'pages/404.html.twig';

    protected function setUp()
    {
        $this->renderer = $this->prophesize(PageRendererService::class);

        $this->controller = new ExceptionController($this->renderer->reveal());
    }

    /**
     * @test
     */
    public function itRenders404WithoutPassingAnException()
    {
        $this->renderer->renderResponse(self::NOT_FOUND, null, Argument::type(Response::class))
            ->willReturnArgument(2);

        $response = $this->controller->notFound(null);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(404, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function itRenders404WithAnException()
    {
        $exception = FlattenException::create(new \Exception());

        $this->renderer->renderResponse(self::NOT_FOUND, null, Argument::type(Response::class))
            ->willReturnArgument(2);

        $response = $this->controller->notFound($exception);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(500, $response->getStatusCode());
    }
}

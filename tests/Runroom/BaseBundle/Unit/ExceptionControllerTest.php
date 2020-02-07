<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Controller\ExceptionController;
use Runroom\BaseBundle\Service\PageRendererService;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;

class ExceptionControllerTest extends TestCase
{
    protected const NOT_FOUND = 'pages/404.html.twig';

    protected $renderer;
    protected $controller;

    protected function setUp(): void
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

        $response = $this->controller->exception(null);

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

        $response = $this->controller->exception($exception);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(500, $response->getStatusCode());
    }
}

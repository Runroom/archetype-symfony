<?php

namespace Tests\Runroom\StaticPageBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\RenderEventBundle\Renderer\PageRenderer;
use Runroom\StaticPageBundle\Controller\StaticPageController;
use Runroom\StaticPageBundle\Service\StaticPageService;
use Runroom\StaticPageBundle\ViewModel\StaticPageViewModel;
use Symfony\Component\HttpFoundation\Response;

class StaticPageControllerTest extends TestCase
{
    protected const STATICS = 'pages/static.html.twig';
    protected const SLUG = 'slug';

    protected $renderer;
    protected $service;
    protected $controller;

    protected function setUp(): void
    {
        $this->renderer = $this->prophesize(PageRenderer::class);
        $this->service = $this->prophesize(StaticPageService::class);

        $this->controller = new StaticPageController(
            $this->renderer->reveal(),
            $this->service->reveal()
        );
    }

    /**
     * @test
     */
    public function itRendersStatic()
    {
        $model = new StaticPageViewModel();
        $expectedResponse = $this->prophesize(Response::class);

        $this->service->getStaticPageViewModel(self::SLUG)->willReturn($model);
        $this->renderer->renderResponse(self::STATICS, $model, null)
            ->willReturn($expectedResponse->reveal());

        $response = $this->controller->staticPage(self::SLUG);

        $this->assertSame($expectedResponse->reveal(), $response);
    }
}

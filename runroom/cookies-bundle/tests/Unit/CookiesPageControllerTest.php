<?php

namespace Runroom\CookiesBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Runroom\CookiesBundle\Controller\CookiesPageController;
use Runroom\CookiesBundle\Service\CookiesPageService;
use Runroom\CookiesBundle\ViewModel\CookiesPageViewModel;
use Runroom\RenderEventBundle\Renderer\PageRenderer;
use Symfony\Component\HttpFoundation\Response;

class CookiesPageControllerTest extends TestCase
{
    use ProphecyTrait;

    private const VIEW = 'pages/cookies.html.twig';

    /** @var ObjectProphecy<PageRenderer> */
    private $renderer;

    /** @var ObjectProphecy<CookiesPageService> */
    private $service;

    /** @var CookiesPageController */
    private $controller;

    protected function setUp(): void
    {
        $this->renderer = $this->prophesize(PageRenderer::class);
        $this->service = $this->prophesize(CookiesPageService::class);

        $this->controller = new CookiesPageController(
            $this->renderer->reveal(),
            $this->service->reveal()
        );
    }

    /** @test */
    public function itRendersCookiesPage(): void
    {
        $viewModel = $this->prophesize(CookiesPageViewModel::class);

        $this->service->getViewModel()->shouldBeCalled()->willReturn($viewModel->reveal());
        $this->renderer->renderResponse(self::VIEW, $viewModel->reveal())->shouldBeCalled();

        $response = $this->controller->index();

        $this->assertInstanceOf(Response::class, $response);
    }
}

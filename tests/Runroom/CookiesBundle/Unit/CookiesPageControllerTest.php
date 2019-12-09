<?php

namespace Tests\Runroom\CookiesBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Service\PageRendererService;
use Runroom\CookiesBundle\Controller\CookiesPageController;
use Runroom\CookiesBundle\Service\CookiesPageService;
use Runroom\CookiesBundle\ViewModel\CookiesPageViewModel;
use Symfony\Component\HttpFoundation\Response;

class CookiesPageControllerTest extends TestCase
{
    protected const VIEW = 'pages/cookies.html.twig';

    protected $renderer;
    protected $service;
    protected $controller;

    protected function setUp(): void
    {
        $this->renderer = $this->prophesize(PageRendererService::class);
        $this->service = $this->prophesize(CookiesPageService::class);

        $this->controller = new CookiesPageController(
            $this->renderer->reveal(),
            $this->service->reveal()
        );
    }

    /**
     * @test
     */
    public function itRendersCookiesPage()
    {
        $viewModel = $this->prophesize(CookiesPageViewModel::class);

        $this->service->getViewModel()->shouldBeCalled()->willReturn($viewModel->reveal());
        $this->renderer->renderResponse(self::VIEW, $viewModel->reveal())->shouldBeCalled();

        $response = $this->controller->index();

        $this->assertInstanceOf(Response::class, $response);
    }
}

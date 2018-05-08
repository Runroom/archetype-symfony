<?php

namespace Tests\Archetype\DemoBundle\Unit;

use Archetype\DemoBundle\Controller\DemoController;
use Archetype\DemoBundle\Service\DemoService;
use Archetype\DemoBundle\ViewModel\DemoViewModel;
use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Service\PageRendererService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class DemoControllerTest extends TestCase
{
    const INDEX_VIEW = 'pages/home.html.twig';

    protected function setUp()
    {
        $this->renderer = $this->prophesize(PageRendererService::class);
        $this->router = $this->prophesize(RouterInterface::class);
        $this->service = $this->prophesize(DemoService::class);

        $this->controller = new DemoController(
            $this->renderer->reveal(),
            $this->router->reveal(),
            $this->service->reveal()
        );
    }

    /**
     * @test
     */
    public function renderIndex()
    {
        $request = new Request();
        $expectedResponse = new Response();
        $model = new DemoViewModel();
        $model->setIsSuccess(false);

        $this->service->getDemoViewModel()->willReturn($model);
        $this->renderer->renderResponse(self::INDEX_VIEW, $model, null)
            ->willReturn($expectedResponse);

        $response = $this->controller->index($request);

        $this->assertSame($expectedResponse, $response);
    }

    /**
     * @test
     */
    public function redirectToIndexAfterForProcess()
    {
        $request = new Request();
        $model = new DemoViewModel();
        $model->setIsSuccess(true);

        $this->router->generate('archetype.demo.route.demo.en', ['_fragment' => 'form'])->willReturn('/#form');
        $this->service->getDemoViewModel()->willReturn($model);

        $response = $this->controller->index($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}

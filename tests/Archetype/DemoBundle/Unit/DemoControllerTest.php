<?php

namespace Tests\Archetype\DemoBundle\Unit;

use Archetype\DemoBundle\Controller\DemoController;
use Archetype\DemoBundle\Service\DemoService;
use Archetype\DemoBundle\ViewModel\DemoViewModel;
use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Service\PageRendererService;
use Symfony\Component\HttpFoundation\Response;

class DemoControllerTest extends TestCase
{
    const INDEX_VIEW = 'pages/home.html.twig';

    protected function setUp()
    {
        $this->renderer = $this->prophesize(PageRendererService::class);
        $this->service = $this->prophesize(DemoService::class);

        $this->controller = new DemoController(
            $this->renderer->reveal(),
            $this->service->reveal()
        );
    }

    /**
     * @test
     */
    public function renderIndex()
    {
        $expectedResponse = $this->prophesize(Response::class);
        $model = new DemoViewModel();

        $this->service->getDemoViewModel()->willReturn($model);
        $this->renderer->renderResponse(self::INDEX_VIEW, $model, null)
            ->willReturn($expectedResponse->reveal());

        $response = $this->controller->index();

        $this->assertSame($expectedResponse->reveal(), $response);
    }
}

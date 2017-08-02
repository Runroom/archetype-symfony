<?php

namespace Tests\Archetype\DemoBundle\Unit;

use Archetype\DemoBundle\Controller\DemoController;
use Archetype\DemoBundle\ViewModel\DemoViewModel;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class DemoControllerTest extends TestCase
{
    const INDEX_VIEW = 'pages/home.html.twig';

    protected function setUp()
    {
        $this->renderer = $this->prophesize('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');
        $this->service = $this->prophesize('Archetype\DemoBundle\Service\DemoService');

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
        $expectedResponse = $this->prophesize('Symfony\Component\HttpFoundation\Response');
        $model = new DemoViewModel();

        $this->service->getDemoViewModel()->willReturn($model);
        $this->renderer->renderResponse(self::INDEX_VIEW, Argument::type('array'), null)
            ->willReturn($expectedResponse->reveal());

        $response = $this->controller->index();

        $this->assertSame($expectedResponse->reveal(), $response);
    }
}

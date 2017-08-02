<?php

namespace Tests\Runroom\StaticPageBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\StaticPageBundle\Controller\StaticPageController;
use Runroom\StaticPageBundle\ViewModel\StaticPageViewModel;

class StaticPageControllerTest extends TestCase
{
    const STATICS = 'pages/static.html.twig';
    const SLUG = 'slug';

    public function setUp()
    {
        $this->renderer = $this->prophesize('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');
        $this->service = $this->prophesize('Runroom\StaticPageBundle\Service\StaticPageService');

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
        $expectedResponse = $this->prophesize('Symfony\Component\HttpFoundation\Response');

        $this->service->getStaticPageViewModel(self::SLUG)->willReturn($model);
        $this->renderer->renderResponse(self::STATICS, Argument::type('array'), null)
            ->willReturn($expectedResponse->reveal());

        $response = $this->controller->staticPage(self::SLUG);

        $this->assertSame($expectedResponse->reveal(), $response);
    }
}

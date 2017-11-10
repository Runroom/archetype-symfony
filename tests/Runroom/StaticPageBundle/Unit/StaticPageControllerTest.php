<?php

namespace Tests\Runroom\StaticPageBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Service\PageRendererService;
use Runroom\StaticPageBundle\Controller\StaticPageController;
use Runroom\StaticPageBundle\Service\StaticPageService;
use Runroom\StaticPageBundle\ViewModel\StaticPageViewModel;
use Symfony\Component\HttpFoundation\Response;

class StaticPageControllerTest extends TestCase
{
    const STATICS = 'pages/static.html.twig';
    const SLUG = 'slug';

    protected function setUp()
    {
        $this->renderer = $this->prophesize(PageRendererService::class);
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

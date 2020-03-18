<?php

namespace Tests\Archetype\DemoBundle\Unit;

use Archetype\DemoBundle\Controller\DemoController;
use Archetype\DemoBundle\Service\DemoService;
use Archetype\DemoBundle\ViewModel\DemoViewModel;
use PHPUnit\Framework\TestCase;
use Runroom\RenderEventBundle\Renderer\PageRenderer;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DemoControllerTest extends TestCase
{
    protected const INDEX_VIEW = 'pages/home.html.twig';
    protected const AJAX_FORM_VIEW = 'pages/ajax-form.html.twig';

    protected $renderer;
    protected $router;
    protected $service;
    protected $formHandler;
    protected $controller;

    protected function setUp(): void
    {
        $this->renderer = $this->prophesize(PageRenderer::class);
        $this->router = $this->prophesize(UrlGeneratorInterface::class);
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
        $form = $this->prophesize(FormInterface::class);

        $request = new Request();
        $expectedResponse = new Response();
        $model = new DemoViewModel();
        $model->setForm($form->reveal());

        $this->service->getDemoViewModel()->willReturn($model);
        $this->renderer->renderResponse(self::INDEX_VIEW, $model, null)
            ->willReturn($expectedResponse);

        $response = $this->controller->index($request);

        $this->assertSame($expectedResponse, $response);
    }

    /**
     * @test
     */
    public function renderAjaxForm()
    {
        $request = new Request();
        $expectedResponse = new Response();
        $form = $this->prophesize(FormInterface::class);

        $this->service->handleForm()->willReturn($form);
        $this->renderer->renderResponse(self::AJAX_FORM_VIEW, $form, null)
            ->willReturn($expectedResponse);

        $response = $this->controller->ajaxForm($request);

        $this->assertSame($expectedResponse, $response);
    }

    /**
     * @test
     */
    public function itRendersOkContactData()
    {
        $form = $this->prophesize(FormInterface::class);

        $form->isSubmitted()->willReturn(true);
        $form->isValid()->willReturn(true);
        $this->service->handleForm()->willReturn($form);

        $response = $this->controller->contactData();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(\json_encode(['status' => 'ok']), $response->getContent());
    }

    /**
     * @test
     */
    public function itRendersKoContactData()
    {
        $form = $this->prophesize(FormInterface::class);

        $form->isSubmitted()->willReturn(false);
        $this->service->handleForm()->willReturn($form);

        $response = $this->controller->contactData();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals(\json_encode(['status' => 'error']), $response->getContent());
    }
}

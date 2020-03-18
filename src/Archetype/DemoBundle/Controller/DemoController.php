<?php

namespace Archetype\DemoBundle\Controller;

use Archetype\DemoBundle\Service\DemoService;
use Runroom\RenderEventBundle\Renderer\PageRenderer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DemoController
{
    protected $renderer;
    protected $router;
    protected $service;

    public function __construct(
        PageRenderer $renderer,
        UrlGeneratorInterface $router,
        DemoService $service
    ) {
        $this->renderer = $renderer;
        $this->router = $router;
        $this->service = $service;
    }

    public function index(): Response
    {
        $model = $this->service->getDemoViewModel();
        $form = $model->getForm();

        if ($form->isSubmitted() && $form->isValid()) {
            return new RedirectResponse(
                $this->router->generate('archetype.demo.route.demo', [
                    '_fragment' => 'form',
                ])
            );
        }

        return $this->renderer->renderResponse('pages/home.html.twig', $model);
    }

    public function ajaxForm(): Response
    {
        $form = $this->service->handleForm();

        return $this->renderer->renderResponse('pages/ajax-form.html.twig', $form);
    }

    public function contactData(): JsonResponse
    {
        $form = $this->service->handleForm();

        if ($form->isSubmitted() && $form->isValid()) {
            return new JsonResponse(['status' => 'ok']);
        }

        return new JsonResponse(['status' => 'error'], Response::HTTP_BAD_REQUEST);
    }
}

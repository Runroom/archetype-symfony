<?php

namespace Archetype\DemoBundle\Controller;

use Archetype\DemoBundle\Form\Type\ContactFormType;
use Archetype\DemoBundle\Service\DemoService;
use Runroom\BaseBundle\Service\FormHandler;
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
    protected $formHandler;

    public function __construct(
        PageRenderer $renderer,
        UrlGeneratorInterface $router,
        DemoService $service,
        FormHandler $formHandler
    ) {
        $this->renderer = $renderer;
        $this->router = $router;
        $this->service = $service;
        $this->formHandler = $formHandler;
    }

    public function index(): Response
    {
        $model = $this->service->getDemoViewModel();

        if ($model->getIsSuccess()) {
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
        $model = $this->service->getAjaxFormViewModel();

        return $this->renderer->renderResponse('pages/ajax-form.html.twig', $model);
    }

    public function contactData(): JsonResponse
    {
        $model = $this->formHandler->handleForm(ContactFormType::class);

        if ($model->getIsSuccess()) {
            return new JsonResponse(['status' => 'ok']);
        }

        return new JsonResponse(['status' => 'error'], Response::HTTP_BAD_REQUEST);
    }
}

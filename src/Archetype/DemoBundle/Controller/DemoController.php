<?php

namespace Archetype\DemoBundle\Controller;

use Archetype\DemoBundle\Service\DemoService;
use Runroom\BaseBundle\Service\PageRendererService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class DemoController
{
    protected $renderer;
    protected $router;
    protected $service;

    public function __construct(
        PageRendererService $renderer,
        RouterInterface $router,
        DemoService $service
    ) {
        $this->renderer = $renderer;
        $this->router = $router;
        $this->service = $service;
    }

    public function index(Request $request): Response
    {
        $model = $this->service->getDemoViewModel();

        if ($model->getIsSuccess()) {
            return new RedirectResponse(
                $this->router->generate('archetype.demo.route.demo.' . $request->getLocale(), [
                    '_fragment' => 'form',
                ])
            );
        }

        return $this->renderer->renderResponse('pages/home.html.twig', $model);
    }
}

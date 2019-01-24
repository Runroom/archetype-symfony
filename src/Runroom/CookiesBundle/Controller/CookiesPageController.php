<?php

namespace Runroom\CookiesBundle\Controller;

use Runroom\BaseBundle\Service\PageRendererService;
use Runroom\CookiesBundle\Service\CookiesPageService;
use Symfony\Component\HttpFoundation\Response;

class CookiesPageController
{
    protected $renderer;
    protected $service;

    public function __construct(
        PageRendererService $renderer,
        CookiesPageService $service
    ) {
        $this->renderer = $renderer;
        $this->service = $service;
    }

    public function index(): Response
    {
        $viewModel = $this->service->getViewModel();

        return $this->renderer->renderResponse('pages/cookies.html.twig', $viewModel);
    }
}

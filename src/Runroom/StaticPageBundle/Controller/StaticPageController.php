<?php

namespace Runroom\StaticPageBundle\Controller;

use Runroom\BaseBundle\Service\PageRendererService;
use Runroom\StaticPageBundle\Service\StaticPageService;
use Symfony\Component\HttpFoundation\Response;

class StaticPageController
{
    protected $service;
    protected $renderer;

    public function __construct(
        PageRendererService $renderer,
        StaticPageService $service
    ) {
        $this->renderer = $renderer;
        $this->service = $service;
    }

    public function staticPage(string $slug): Response
    {
        $model = $this->service->getStaticPageViewModel($slug);

        return $this->renderer->renderResponse('pages/static.html.twig', $model);
    }
}

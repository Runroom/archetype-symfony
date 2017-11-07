<?php

namespace Archetype\DemoBundle\Controller;

use Archetype\DemoBundle\Service\DemoService;
use Runroom\BaseBundle\Service\PageRendererService;
use Symfony\Component\HttpFoundation\Response;

class DemoController
{
    const INDEX_VIEW = 'pages/home.html.twig';
    protected $service;
    protected $renderer;

    public function __construct(PageRendererService $renderer, DemoService $service)
    {
        $this->renderer = $renderer;
        $this->service = $service;
    }

    public function index(): Response
    {
        $model = $this->service->getDemoViewModel();

        return $this->renderer->renderResponse(self::INDEX_VIEW, $model);
    }
}

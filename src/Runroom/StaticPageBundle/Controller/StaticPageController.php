<?php

namespace Runroom\StaticPageBundle\Controller;

use Runroom\BaseBundle\Service\PageRendererService;
use Runroom\StaticPageBundle\Service\StaticPageService;
use Symfony\Component\HttpFoundation\Response;

class StaticPageController
{
    const STATIC_PAGE = 'pages/static.html.twig';

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

        return $this->renderer->renderResponse(self::STATIC_PAGE, $model);
    }
}

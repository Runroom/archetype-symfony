<?php

namespace Runroom\BaseBundle\Controller;

use Runroom\BaseBundle\Service\PageRendererService;
use Symfony\Component\HttpFoundation\Response;

class ExceptionController
{
    const NOT_FOUND = 'pages/404.html.twig';

    protected $renderer;

    public function __construct(PageRendererService $renderer)
    {
        $this->renderer = $renderer;
    }

    public function notFound(): Response
    {
        return $this->renderer->renderResponse(self::NOT_FOUND, null, new Response('', 404));
    }
}

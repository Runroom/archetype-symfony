<?php

namespace Runroom\BaseBundle\Controller;

use Runroom\BaseBundle\Service\PageRendererService;
use Symfony\Component\HttpFoundation\Response;

class ExceptionController
{
    protected $renderer;

    public function __construct(PageRendererService $renderer)
    {
        $this->renderer = $renderer;
    }

    public function notFound(): Response
    {
        return $this->renderer->renderResponse('pages/404.html.twig', null, new Response('', 404));
    }
}

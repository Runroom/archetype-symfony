<?php

namespace App\Controller;

use Doctrine\ORM\NoResultException;
use Runroom\RenderEventBundle\Renderer\PageRenderer;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;

class ExceptionController
{
    protected $renderer;

    public function __construct(PageRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function exception(?FlattenException $exception): Response
    {
        return $this->renderer->renderResponse(
            'pages/404.html.twig',
            null,
            new Response('', $this->getStatusCode($exception))
        );
    }

    private function getStatusCode(?FlattenException $exception): int
    {
        if (\is_null($exception) || $exception->getClass() === NoResultException::class) {
            return 404;
        }

        return $exception->getStatusCode();
    }
}

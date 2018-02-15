<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\Event\PageRenderEvent;
use Runroom\BaseBundle\ViewModel\PageViewModelInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class PageRendererService
{
    protected $twig;
    protected $eventDispatcher;
    protected $pageViewModel;

    public function __construct(
        Environment $twig,
        EventDispatcherInterface $eventDispatcher,
        PageViewModelInterface $pageViewModel
    ) {
        $this->twig = $twig;
        $this->eventDispatcher = $eventDispatcher;
        $this->pageViewModel = $pageViewModel;
    }

    public function renderResponse(string $view, $model = null, Response $response = null): Response
    {
        $this->pageViewModel->setContent($model);
        $event = new PageRenderEvent($view, $this->pageViewModel, $response ?? new Response());

        $this->eventDispatcher->dispatch(PageRenderEvent::EVENT_NAME, $event);

        $response = $event->getResponse();
        if ($response instanceof RedirectResponse || !empty($response->getContent())) {
            return $response;
        }

        return $response->setContent($this->twig->render(
            $event->getView(),
            ['page' => $event->getPageViewModel()]
        ));
    }
}

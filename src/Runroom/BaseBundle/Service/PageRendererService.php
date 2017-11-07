<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\Event\PageEvent;
use Runroom\BaseBundle\ViewModel\PageViewModelInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;

class PageRendererService
{
    protected $renderer;
    protected $eventDispatcher;
    protected $pageViewModel;

    public function __construct(
        EngineInterface $renderer,
        EventDispatcherInterface $eventDispatcher,
        PageViewModelInterface $pageViewModel
    ) {
        $this->renderer = $renderer;
        $this->eventDispatcher = $eventDispatcher;
        $this->pageViewModel = $pageViewModel;
    }

    public function renderResponse(string $view, $model = null, Response $response = null): Response
    {
        $this->pageViewModel->setContent($model);
        $event = new PageEvent($this->pageViewModel);

        $this->eventDispatcher->dispatch(PageEvent::RENDER_EVENT, $event);

        return $this->renderer->renderResponse($view, [
            'page' => $event->getPage(),
        ], $response);
    }
}

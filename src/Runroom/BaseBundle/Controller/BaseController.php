<?php

namespace Runroom\BaseBundle\Controller;

use Runroom\BaseBundle\Event\PageEvent;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;

class BaseController
{
    const RENDER_EVENT = 'runroom.events.page.render';

    protected $renderer;
    protected $eventDispatcher;

    public function __construct(EngineInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    protected function renderResponse(string $view, $model = null, Response $response = null): Response
    {
        $event = new PageEvent($model);

        $this->dispatchEvent(self::RENDER_EVENT, $event);

        return $this->renderer->renderResponse($view, [
            'page' => $event->getPage(),
        ], $response);
    }

    protected function dispatchEvent(string $name, PageEvent $event): void
    {
        if (!is_null($this->eventDispatcher)) {
            $this->eventDispatcher->dispatch($name, $event);
        }
    }
}

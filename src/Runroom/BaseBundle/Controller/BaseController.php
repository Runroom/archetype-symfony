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
    protected $event_dispatcher;

    public function __construct(EngineInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function setEventDispatcher(EventDispatcherInterface $event_dispatcher)
    {
        $this->event_dispatcher = $event_dispatcher;
    }

    protected function renderResponse($view, $model = null, Response $response = null)
    {
        $event = new PageEvent($model);

        $this->dispatchEvent(self::RENDER_EVENT, $event);

        return $this->renderer->renderResponse($view, [
            'page' => $event->getPage(),
        ], $response);
    }

    protected function dispatchEvent($name, $event)
    {
        if (!is_null($this->event_dispatcher)) {
            $this->event_dispatcher->dispatch($name, $event);
        }
    }
}

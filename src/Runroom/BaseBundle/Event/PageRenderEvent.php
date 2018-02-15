<?php

namespace Runroom\BaseBundle\Event;

use Runroom\BaseBundle\ViewModel\PageViewModelInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;

class PageRenderEvent extends Event
{
    const EVENT_NAME = 'runroom.events.page.render';

    protected $view;
    protected $pageViewModel;
    protected $response;

    public function __construct(
        string $view,
        PageViewModelInterface $pageViewModel,
        Response $response
    ) {
        $this->view = $view;
        $this->pageViewModel = $pageViewModel;
        $this->response = $response;
    }

    public function setView(string $view): self
    {
        $this->view = $view;

        return $this;
    }

    public function getView(): string
    {
        return $this->view;
    }

    public function setPageViewModel(PageViewModelInterface $pageViewModel): self
    {
        $this->pageViewModel = $pageViewModel;

        return $this;
    }

    public function getPageViewModel(): PageViewModelInterface
    {
        return $this->pageViewModel;
    }

    public function setResponse(Response $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}

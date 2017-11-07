<?php

namespace Runroom\BaseBundle\Event;

use Runroom\BaseBundle\ViewModel\PageViewModelInterface;
use Symfony\Component\EventDispatcher\Event;

class PageEvent extends Event
{
    const RENDER_EVENT = 'runroom.events.page.render';

    protected $page;

    public function __construct(PageViewModelInterface $pageViewModel)
    {
        $this->page = $pageViewModel;
    }

    public function getPage(): PageViewModelInterface
    {
        return $this->page;
    }

    public function setPage(PageViewModelInterface $page): void
    {
        $this->page = $page;
    }
}

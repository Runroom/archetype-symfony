<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\Event\PageEvent;
use Runroom\BaseBundle\Repository\StaticPageRepository;
use Runroom\BaseBundle\ViewModel\StaticPageViewModel;

class StaticPageService
{
    protected $repository;

    public function __construct(StaticPageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getStaticPageViewModel($static_page_slug)
    {
        $static_page = $this->repository->findStaticPage($static_page_slug);

        $model = new StaticPageViewModel();
        $model->setStaticPage($static_page);

        return $model;
    }

    public function onPageEvent(PageEvent $event)
    {
        $page = $event->getPage();

        $footer_static_pages = $this->repository->findFooterStaticPages();
        $page->setFooterStaticPages($footer_static_pages);

        $event->setPage($page);
    }
}

<?php

namespace Runroom\StaticPageBundle\Service;

use Runroom\BaseBundle\Event\PageEvent;
use Runroom\StaticPageBundle\Repository\StaticPageRepository;
use Runroom\StaticPageBundle\ViewModel\StaticPageViewModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StaticPageService implements EventSubscriberInterface
{
    protected $repository;

    public function __construct(StaticPageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getStaticPageViewModel(string $slug): StaticPageViewModel
    {
        $staticPage = $this->repository->findStaticPage($slug);

        $model = new StaticPageViewModel();
        $model->setStaticPage($staticPage);

        return $model;
    }

    public function onPageRender(PageEvent $event): void
    {
        $page = $event->getPage();

        $staticPages = $this->repository->findVisibleStaticPages();
        $page->setStaticPages($staticPages);

        $event->setPage($page);
    }

    public static function getSubscribedEvents()
    {
        return [
            PageEvent::RENDER_EVENT => 'onPageRender',
        ];
    }
}

<?php

namespace Runroom\StaticPageBundle\Service;

use Runroom\RenderEventBundle\Event\PageRenderEvent;
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
        $staticPage = $this->repository->findBySlug($slug);

        $model = new StaticPageViewModel();
        $model->setStaticPage($staticPage);

        return $model;
    }

    public function onPageRender(PageRenderEvent $event): void
    {
        $page = $event->getPageViewModel();

        $page->addContext('static_pages', $this->repository->findBy(['publish' => true]));

        $event->setPageViewModel($page);
    }

    public static function getSubscribedEvents()
    {
        return [
            PageRenderEvent::EVENT_NAME => 'onPageRender',
        ];
    }
}

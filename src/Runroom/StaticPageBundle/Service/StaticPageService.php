<?php

namespace Runroom\StaticPageBundle\Service;

use Runroom\StaticPageBundle\Repository\StaticPageRepository;
use Runroom\StaticPageBundle\ViewModel\StaticPageViewModel;

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
}

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

    public function getStaticPageViewModel(string $slug): StaticPageViewModel
    {
        $staticPage = $this->repository->findStaticPage($slug);

        $model = new StaticPageViewModel();
        $model->setStaticPage($staticPage);

        return $model;
    }
}

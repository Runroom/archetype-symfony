<?php

namespace Runroom\DemoBundle\Service;

use Runroom\DemoBundle\Repository\DemoRepository;
use Runroom\DemoBundle\ViewModel\DemoViewModel;

class DemoService {

    protected $repository;

    public function __construct(DemoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getDemoViewModel()
    {
        $demos = $this->repository->findDemos();

        $model = new DemoViewModel();
        $model->setDemos($demos);

        return $model;
    }
}

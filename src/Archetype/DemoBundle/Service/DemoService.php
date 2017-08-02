<?php

namespace Archetype\DemoBundle\Service;

use Archetype\DemoBundle\Repository\BookRepository;
use Archetype\DemoBundle\ViewModel\DemoViewModel;

class DemoService
{
    protected $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getDemoViewModel(): DemoViewModel
    {
        $books = $this->repository->findBooks();

        $model = new DemoViewModel();
        $model->setBooks($books);

        return $model;
    }
}

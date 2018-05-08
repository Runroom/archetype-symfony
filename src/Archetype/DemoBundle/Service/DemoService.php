<?php

namespace Archetype\DemoBundle\Service;

use Archetype\DemoBundle\Form\Type\ContactFormType;
use Archetype\DemoBundle\Repository\BookRepository;
use Archetype\DemoBundle\ViewModel\DemoViewModel;
use Runroom\BaseBundle\Service\FormHandler;

class DemoService
{
    protected $repository;
    protected $handler;

    public function __construct(BookRepository $repository, FormHandler $handler)
    {
        $this->repository = $repository;
        $this->handler = $handler;
    }

    public function getDemoViewModel(): DemoViewModel
    {
        $books = $this->repository->findBooks();

        $model = new DemoViewModel();
        $model->setBooks($books);

        return $this->handler->handleForm(ContactFormType::class, $model);
    }
}

<?php

namespace Archetype\DemoBundle\Service;

use Archetype\DemoBundle\Form\Type\ContactFormType;
use Archetype\DemoBundle\Repository\BookRepository;
use Archetype\DemoBundle\ViewModel\AjaxFormViewModel;
use Archetype\DemoBundle\ViewModel\DemoViewModel;
use Runroom\FormHandlerBundle\FormHandler;

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
        $books = $this->repository->findBy(['publish' => true], ['position' => 'ASC']);

        $model = new DemoViewModel();
        $model->setBooks($books);

        return $this->handler->handleForm(ContactFormType::class, $model);
    }

    public function getAjaxFormViewModel(): AjaxFormViewModel
    {
        $model = new AjaxFormViewModel();

        return $this->handler->handleForm(ContactFormType::class, $model);
    }
}

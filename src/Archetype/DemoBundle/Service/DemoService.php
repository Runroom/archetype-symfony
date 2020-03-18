<?php

namespace Archetype\DemoBundle\Service;

use Archetype\DemoBundle\Entity\Contact;
use Archetype\DemoBundle\Form\Type\ContactFormType;
use Archetype\DemoBundle\Repository\BookRepository;
use Archetype\DemoBundle\ViewModel\DemoViewModel;
use Runroom\BaseBundle\Service\FormHandler;
use Symfony\Component\Form\FormInterface;

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
        $model->setForm($this->handleForm());

        return $model;
    }

    public function handleForm(): FormInterface
    {
        return $this->handler->handleForm(ContactFormType::class, new Contact());
    }
}

<?php

namespace Archetype\DemoBundle\ViewModel;

use Symfony\Component\Form\FormInterface;

class DemoViewModel
{
    protected $books;
    protected $form;

    public function setBooks(array $books): self
    {
        $this->books = $books;

        return $this;
    }

    public function getBooks(): ?array
    {
        return $this->books;
    }

    public function setForm(FormInterface $form): self
    {
        $this->form = $form;

        return $this;
    }

    public function getForm(): ?FormInterface
    {
        return $this->form;
    }
}

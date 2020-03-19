<?php

namespace Archetype\DemoBundle\ViewModel;

use Runroom\FormHandlerBundle\ViewModel\FormAware;
use Runroom\FormHandlerBundle\ViewModel\FormAwareInterface;

class DemoViewModel implements FormAwareInterface
{
    use FormAware;

    protected $books;

    public function setBooks(array $books): void
    {
        $this->books = $books;
    }

    public function getBooks(): ?array
    {
        return $this->books;
    }
}

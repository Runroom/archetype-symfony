<?php

namespace Archetype\DemoBundle\ViewModel;

use Runroom\BaseBundle\ViewModel\FormAware;
use Runroom\BaseBundle\ViewModel\FormAwareInterface;

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

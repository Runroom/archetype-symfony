<?php

namespace Archetype\DemoBundle\ViewModel;

class DemoViewModel
{
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

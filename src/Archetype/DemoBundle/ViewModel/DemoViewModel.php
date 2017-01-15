<?php

namespace Archetype\DemoBundle\ViewModel;

class DemoViewModel
{
    protected $books;

    public function getBooks()
    {
        return $this->books;
    }

    public function setBooks(array $books)
    {
        $this->books = $books;
    }
}

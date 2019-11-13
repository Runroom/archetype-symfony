<?php

namespace Tests\Archetype\DemoBundle\Fixtures;

use Archetype\DemoBundle\Entity\Book;
use Runroom\BaseBundle\Entity\Media;

class BookFixture
{
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const POSITION = 0;

    public static function create(): Book
    {
        $category = CategoryFixture::create();
        $picture = new Media();

        $book = new Book();
        $book->translate()->setTitle(self::TITLE);
        $book->translate()->setDescription(self::DESCRIPTION);
        $book->setPosition(self::POSITION);
        $book->setCategory($category);
        $book->setPicture($picture);

        $category->addBook($book);

        return $book;
    }
}

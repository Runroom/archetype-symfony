<?php

namespace Tests\Archetype\DemoBundle\MotherObjects;

use Application\Sonata\MediaBundle\Entity\Media;
use Archetype\DemoBundle\Entity\Book;

class BookMotherObject
{
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const POSITION = 0;

    public static function create()
    {
        $category = CategoryMotherObject::create();
        $picture = new Media();

        $book = new Book();
        $book->setTitle(self::TITLE);
        $book->setDescription(self::DESCRIPTION);
        $book->setPosition(self::POSITION);
        $book->setCategory($category);
        $book->setPicture($picture);

        $category->addBook($book);

        return $book;
    }
}

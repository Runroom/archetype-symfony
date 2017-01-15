<?php

namespace Tests\Archetype\DemoBundle\Integration;

use Tests\Runroom\BaseBundle\Integration\DoctrineIntegrationTestBase;

class BookRepositoryIntegrationTest extends DoctrineIntegrationTestBase
{
    const BOOK_COUNT = 3;
    const BOOK_ID = 1;
    const BOOK_TITLE = 'name';
    const BOOK_DESCRIPTION = 'description';
    const BOOK_POSITION = 0;
    const CATEGORY_ID = 1;
    const CATEGORY_NAME = 'name';
    const CATEGORY_BOOK_COUNT = 1;

    protected function setUp()
    {
        parent::setUp();
        $this->repository = $this->getContainer()->get('archetype.demo.repository.book');
    }

    public function getDataSetFile()
    {
        return __DIR__ . '/seeds/book-seeds.xml';
    }

    /**
     * @test
     */
    public function itFindsDemos()
    {
        $books = $this->repository->findBooks();

        $book = $books[0];
        $category = $book->getCategory();
        $picture = $book->getPicture();

        $this->assertCount(self::BOOK_COUNT, $books);
        $this->assertEquals(self::BOOK_TITLE, $book);
        $this->assertEquals(self::BOOK_ID, $book->getId());
        $this->assertEquals(self::BOOK_DESCRIPTION, $book->getDescription());
        $this->assertEquals(self::BOOK_POSITION, $book->getPosition());
        $this->assertInstanceOf('Archetype\DemoBundle\Entity\Category', $category);
        $this->assertEquals(self::CATEGORY_NAME, $category);
        $this->assertEquals(self::CATEGORY_ID, $category->getId());
        $this->assertCount(self::CATEGORY_BOOK_COUNT, $category->getBooks());
        $this->assertInstanceOf('Application\Sonata\MediaBundle\Entity\Media', $picture);

        $category->removeBook($book);

        $this->assertCount(0, $category->getBooks());
    }
}

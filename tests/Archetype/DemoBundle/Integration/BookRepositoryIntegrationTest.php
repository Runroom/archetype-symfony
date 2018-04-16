<?php

namespace Tests\Archetype\DemoBundle\Integration;

use Archetype\DemoBundle\Entity\Category;
use Archetype\DemoBundle\Repository\BookRepository;
use Runroom\BaseBundle\Entity\Media;
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

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new BookRepository(static::$entityManager);
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
        $this->assertSame(self::BOOK_TITLE, $book->__toString());
        $this->assertSame(self::BOOK_ID, $book->getId());
        $this->assertSame(self::BOOK_DESCRIPTION, $book->getDescription());
        $this->assertSame(self::BOOK_POSITION, $book->getPosition());
        $this->assertInstanceOf(Category::class, $category);
        $this->assertSame(self::CATEGORY_NAME, $category->__toString());
        $this->assertSame(self::CATEGORY_ID, $category->getId());
        $this->assertCount(self::CATEGORY_BOOK_COUNT, $category->getBooks());
        $this->assertInstanceOf(Media::class, $picture);

        $category->removeBook($book);

        $this->assertCount(0, $category->getBooks());
    }

    protected function getDataSetFile()
    {
        return __DIR__ . '/seeds/book-seeds.xml';
    }
}

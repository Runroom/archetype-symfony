<?php

namespace Tests\Archetype\DemoBundle\Integration;

use Archetype\DemoBundle\Entity\Category;
use Archetype\DemoBundle\Repository\BookRepository;
use Runroom\BaseBundle\Entity\Media;
use Tests\Runroom\BaseBundle\TestCase\DoctrineTestCase;

class BookRepositoryTest extends DoctrineTestCase
{
    protected const BOOK_COUNT = 10;
    protected const BOOK_ID = 1;
    protected const BOOK_TITLE = 'name';
    protected const BOOK_DESCRIPTION = 'description';
    protected const BOOK_POSITION = 0;
    protected const CATEGORY_ID = 1;
    protected const CATEGORY_NAME = 'name';
    protected const CATEGORY_BOOK_COUNT = 9;

    protected $repository;

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

        $this->assertLessThan(self::BOOK_COUNT, \count($books));
        $this->assertCount(self::CATEGORY_BOOK_COUNT, $category->getBooks());

        $this->assertNotNull($book->getId());
        $this->assertNotNull($category->getId());
        $this->assertNotNull($book->__toString());
        $this->assertNotNull($book->getDescription());
        $this->assertNotNull($category->__toString());
        $this->assertSame(self::BOOK_POSITION, $book->getPosition());

        $this->assertInstanceOf(Category::class, $category);
        $this->assertInstanceOf(Media::class, $picture);

        $category->removeBook($book);

        $this->assertCount(self::CATEGORY_BOOK_COUNT - 1, $category->getBooks());
    }

    protected function getDataFixtures(): array
    {
        return ['books.yaml'];
    }
}

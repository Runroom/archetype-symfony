<?php

namespace Tests\Runroom\StaticPageBundle\Integration;

use Doctrine\ORM\NoResultException;
use Runroom\StaticPageBundle\Entity\StaticPage;
use Runroom\StaticPageBundle\Repository\StaticPageRepository;
use Tests\TestCase\DoctrineTestCase;

class StaticPageRepositoryTest extends DoctrineTestCase
{
    protected const STATIC_PAGE_ID = 1;

    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = static::$container->get(StaticPageRepository::class);
    }

    /**
     * @test
     */
    public function itFindsStaticPageGivenItsSlug()
    {
        $staticPage = $this->repository->findBySlug('slug');

        $this->assertInstanceOf(StaticPage::class, $staticPage);
        $this->assertSame(self::STATIC_PAGE_ID, $staticPage->getId());
    }

    /**
     * @test
     */
    public function itDoesNotFindUnPublishedStatigPage()
    {
        $this->expectException(NoResultException::class);

        $this->repository->findBySlug('unpublished');
    }

    protected function getDataFixtures(): array
    {
        return ['static_pages.yaml'];
    }
}

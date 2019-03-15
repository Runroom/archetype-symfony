<?php

namespace Tests\Runroom\StaticPageBundle\Integration;

use Doctrine\ORM\NoResultException;
use Runroom\StaticPageBundle\Entity\StaticPage;
use Runroom\StaticPageBundle\Repository\StaticPageRepository;
use Tests\Runroom\BaseBundle\TestCase\DoctrineIntegrationTestBase;

class StaticPageRepositoryTest extends DoctrineIntegrationTestBase
{
    const STATIC_PAGE_ID = 1;
    const VISIBLE_STATIC_PAGES_COUNT = 1;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new StaticPageRepository(static::$entityManager);
    }

    /**
     * @test
     */
    public function itFindsStaticPageGivenItsSlug()
    {
        $staticPage = $this->repository->findStaticPage('slug');

        $this->assertInstanceOf(StaticPage::class, $staticPage);
        $this->assertSame(self::STATIC_PAGE_ID, $staticPage->getId());
    }

    /**
     * @test
     */
    public function itDoesNotFindUnPublishedStatigPage()
    {
        $this->expectException(NoResultException::class);

        $this->repository->findStaticPage('unpublished');
    }

    /**
     * @test
     */
    public function itFindsVisibleStaticPages()
    {
        $staticPages = $this->repository->findVisibleStaticPages();

        $this->assertContainsOnlyInstancesOf(StaticPage::class, $staticPages);
        $this->assertCount(self::VISIBLE_STATIC_PAGES_COUNT, $staticPages);
    }

    protected function getDataFixtures(): array
    {
        return ['static_pages.yml'];
    }
}

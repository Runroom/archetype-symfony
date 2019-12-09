<?php

namespace Tests\Runroom\StaticPageBundle\Integration;

use Doctrine\ORM\NoResultException;
use Runroom\StaticPageBundle\Entity\StaticPage;
use Runroom\StaticPageBundle\Repository\StaticPageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Tests\Runroom\BaseBundle\TestCase\DoctrineTestCase;

class StaticPageRepositoryTest extends DoctrineTestCase
{
    protected const STATIC_PAGE_ID = 1;
    protected const VISIBLE_STATIC_PAGES_COUNT = 1;

    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $requestStack = new RequestStack();
        $requestStack->push(new Request());

        $this->repository = new StaticPageRepository(
            static::$entityManager,
            $requestStack
        );
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
        return ['static_pages.yaml'];
    }
}

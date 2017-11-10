<?php

namespace Tests\Runroom\StaticPageBundle\Integration;

use Runroom\StaticPageBundle\Entity\StaticPage;
use Runroom\StaticPageBundle\Repository\StaticPageRepository;
use Tests\Runroom\BaseBundle\Integration\DoctrineIntegrationTestBase;

class StaticPageRepositoryTest extends DoctrineIntegrationTestBase
{
    const STATIC_PAGE_ID = 1;

    protected function setUp()
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
     * @expectedException \Doctrine\ORM\NoResultException
     */
    public function itDoesNotFindUnPublishedStatigPage()
    {
        $this->repository->findStaticPage('unpublished');
    }

    protected function getDataSetFile()
    {
        return __DIR__ . '/seeds/static-page-seeds.xml';
    }
}

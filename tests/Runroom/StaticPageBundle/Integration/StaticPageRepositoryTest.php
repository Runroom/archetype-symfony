<?php

namespace Tests\Runroom\StaticPageBundle\Integration;

use Tests\Runroom\BaseBundle\Integration\DoctrineIntegrationTestBase;

class StaticPageRepositoryTest extends DoctrineIntegrationTestBase
{
    const STATIC_PAGE_ID = 1;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getContainer()->get('runroom.static_page.repository.static_page');
    }

    protected function getDataSetFile()
    {
        return __DIR__ . '/seeds/static-page-seeds.xml';
    }

    /**
     * @test
     */
    public function itFindsStaticPageGivenItsSlug()
    {
        $staticPage = $this->repository->findStaticPage('slug');

        $this->assertInstanceOf('Runroom\StaticPageBundle\Entity\StaticPage', $staticPage);
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
}

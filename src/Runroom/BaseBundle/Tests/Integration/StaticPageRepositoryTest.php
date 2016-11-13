<?php

namespace Runroom\BaseBundle\Tests\Integration;

class StaticPageRepositoryTest extends DoctrineIntegrationTestBase
{
    const STATIC_PAGE_ID = 1;
    const FOOTER_STATIC_PAGES_COUNT = 1;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getContainer()->get('runroom.base.repository.static_page');
    }

    public function getDataSetFile()
    {
        return __DIR__ . '/seeds/static-page-seeds.xml';
    }

    /**
     * @test
     */
    public function itFindsStaticPageGivenItsSlug()
    {
        $static_page = $this->repository->findStaticPage('slug');

        $this->assertInstanceOf('Runroom\BaseBundle\Entity\StaticPage', $static_page);
        $this->assertEquals(self::STATIC_PAGE_ID, $static_page->getId());
    }

    /**
     * @test
     * @expectedException \Doctrine\ORM\NoResultException
     */
    public function itDoesNotFindUnPublishedStatigPage()
    {
        $this->repository->findStaticPage('unpublished');
    }

    /**
     * @test
     */
    public function itFindsFooterStaticPages()
    {
        $footer_static_pages = $this->repository->findFooterStaticPages();

        $this->assertCount(self::FOOTER_STATIC_PAGES_COUNT, $footer_static_pages);
    }
}

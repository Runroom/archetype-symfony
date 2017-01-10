<?php

namespace Tests\Runroom\BaseBundle\Integration;

class MetaInformationRepositoryTest extends DoctrineIntegrationTestBase
{
    const DEFAULT_ROUTE = 'default';
    const HOME_ROUTE = 'home';
    const NOT_FOUND_ROUTE = 'not-found';

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getContainer()->get('runroom.base.repository.meta_information');
    }

    public function getDataSetFile()
    {
        return __DIR__ . '/seeds/meta-information-seeds.xml';
    }

    /**
     * @test
     */
    public function itFindsRouteMetaInformation()
    {
        $meta_information = $this->repository->findOneByRoute(self::HOME_ROUTE);

        $this->assertInstanceOf('Runroom\BaseBundle\Entity\MetaInformation', $meta_information);
    }

    /**
     * @test
     */
    public function itDoesNotFindUnpublishedRouteMetaInformation()
    {
        $meta_information = $this->repository->findOneByRoute(self::NOT_FOUND_ROUTE);

        $this->assertNull($meta_information);
    }
}

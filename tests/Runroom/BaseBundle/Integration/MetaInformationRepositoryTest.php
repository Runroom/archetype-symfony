<?php

namespace Tests\Runroom\BaseBundle\Integration;

use Runroom\BaseBundle\Entity\MetaInformation;
use Runroom\BaseBundle\Repository\MetaInformationRepository;
use Tests\Runroom\BaseBundle\TestCase\DoctrineIntegrationTestBase;

class MetaInformationRepositoryTest extends DoctrineIntegrationTestBase
{
    const DEFAULT_ROUTE = 'default';
    const HOME_ROUTE = 'home';
    const NOT_FOUND_ROUTE = 'not-found';

    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new MetaInformationRepository(static::$entityManager);
    }

    /**
     * @test
     */
    public function itFindsRouteMetaInformation()
    {
        $metaInformation = $this->repository->findOneByRoute(self::HOME_ROUTE);

        $this->assertInstanceOf(MetaInformation::class, $metaInformation);
    }

    /**
     * @test
     */
    public function itDoesNotFindUnpublishedRouteMetaInformation()
    {
        $metaInformation = $this->repository->findOneByRoute(self::NOT_FOUND_ROUTE);

        $this->assertNull($metaInformation);
    }

    protected function getDataFixtures(): array
    {
        return ['meta_informations.yaml'];
    }
}

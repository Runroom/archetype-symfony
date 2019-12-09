<?php

namespace Tests\Runroom\CookiesBundle\Integration;

use Runroom\CookiesBundle\Entity\CookiesPage;
use Runroom\CookiesBundle\Repository\CookiesPageRepository;
use Tests\Runroom\BaseBundle\TestCase\DoctrineTestCase;

class CookiesPageRepositoryTest extends DoctrineTestCase
{
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new CookiesPageRepository(static::$entityManager);
    }

    /**
     * @test
     */
    public function itFindsCookiesPage()
    {
        $cookies = $this->repository->find();

        $this->assertInstanceOf(CookiesPage::class, $cookies);
    }

    protected function getDataFixtures(): array
    {
        return ['cookies_page.yaml'];
    }
}

<?php

namespace Runroom\DemoBundle\Tests\Integration;

class DemoRepositoryIntegrationTest extends DoctrineIntegrationTestBase {

    const DEMO_COUNT = 3;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getContainer()->get('runroom.demo.repository.demo');
    }

    public function getDataSetFile()
    {
        return __DIR__ . '/seeds/demo-seeds.xml';
    }

    /**
     * @test
     */
    public function itFindsDemos()
    {
        $demos = $this->repository->findDemo();

        $this->assertCount(self::DEMO_COUNT, $demos);
    }
}

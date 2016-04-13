<?php

namespace Runroom\DemoBundle\Tests\Integration;

class DemoRepositoryIntegrationTest extends DoctrineIntegrationTestBase {

    const DEMO_COUNT = 3;
    const DEMO0_NAME = 'name';
    const DEMO0_ID = 1;

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
        $demos = $this->repository->findDemos();

        $this->assertCount(self::DEMO_COUNT, $demos);

        $this->assertEquals(self::DEMO0_NAME, $demos[0]);

        $this->assertEquals(self::DEMO0_ID, $demos[0]->getId());
    }
}

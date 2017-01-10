<?php

namespace Tests\Archetype\DemoBundle\Unit;

use Archetype\DemoBundle\Service\DemoService;
use Tests\Archetype\DemoBundle\MotherObjects\DemoMotherObject;

class DemoServiceTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->repository = $this->prophesize('Archetype\DemoBundle\Repository\DemoRepository');
        $this->service = new DemoService($this->repository->reveal());
    }

    /**
     * @test
     */
    public function itGeneratesDemoViewModel()
    {
        $expected_demos = [DemoMotherObject::create()];
        $this->repository->findDemos()
            ->willReturn($expected_demos);

        $demo_view_model = $this->service->getDemoViewModel();
        $this->assertInstanceOf(
            'Archetype\DemoBundle\ViewModel\DemoViewModel',
            $demo_view_model
        );

        $demos = $demo_view_model->getDemos();
        $this->assertSame($demos, $expected_demos);
    }
}

<?php

namespace Runroom\DemoBundle\Tests\Unit;

use Runroom\DemoBundle\Service\DemoService;
use Runroom\DemoBundle\Tests\MotherObjects\DemoMotherObject;

class DemoServiceTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->repository = $this->prophesize('Runroom\DemoBundle\Repository\DemoRepository');
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
            'Runroom\DemoBundle\ViewModel\DemoViewModel',
            $demo_view_model
        );

        $demos = $demo_view_model->getDemos();
        $this->assertSame($demos, $expected_demos);
    }
}

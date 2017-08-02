<?php

namespace Tests\Archetype\DemoBundle\Unit;

use Archetype\DemoBundle\Service\DemoService;
use PHPUnit\Framework\TestCase;
use Tests\Archetype\DemoBundle\MotherObjects\BookMotherObject;

class DemoServiceTest extends TestCase
{
    protected function setUp()
    {
        $this->repository = $this->prophesize('Archetype\DemoBundle\Repository\BookRepository');
        $this->service = new DemoService($this->repository->reveal());
    }

    /**
     * @test
     */
    public function itGeneratesDemoViewModel()
    {
        $expectedBooks = [BookMotherObject::create()];

        $this->repository->findBooks()->willReturn($expectedBooks);

        $model = $this->service->getDemoViewModel();

        $this->assertInstanceOf('Archetype\DemoBundle\ViewModel\DemoViewModel', $model);
        $this->assertSame($model->getBooks(), $expectedBooks);
    }
}

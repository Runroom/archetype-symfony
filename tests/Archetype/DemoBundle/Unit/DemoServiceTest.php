<?php

namespace Tests\Archetype\DemoBundle\Unit;

use Archetype\DemoBundle\Repository\BookRepository;
use Archetype\DemoBundle\Service\DemoService;
use Archetype\DemoBundle\ViewModel\DemoViewModel;
use PHPUnit\Framework\TestCase;
use Tests\Archetype\DemoBundle\MotherObjects\BookMotherObject;

class DemoServiceTest extends TestCase
{
    protected function setUp()
    {
        $this->repository = $this->prophesize(BookRepository::class);
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

        $this->assertInstanceOf(DemoViewModel::class, $model);
        $this->assertSame($model->getBooks(), $expectedBooks);
    }
}

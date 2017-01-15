<?php

namespace Tests\Archetype\DemoBundle\Unit;

use Archetype\DemoBundle\Service\DemoService;
use Tests\Archetype\DemoBundle\MotherObjects\BookMotherObject;

class DemoServiceTest extends \PHPUnit_Framework_TestCase
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
        $expected_books = [BookMotherObject::create()];

        $this->repository->findBooks()
            ->willReturn($expected_books);

        $model = $this->service->getDemoViewModel();

        $this->assertInstanceOf('Archetype\DemoBundle\ViewModel\DemoViewModel', $model);
        $this->assertSame($model->getBooks(), $expected_books);
    }
}

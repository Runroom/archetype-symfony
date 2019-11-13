<?php

namespace Tests\Archetype\DemoBundle\Unit;

use Archetype\DemoBundle\Form\Type\ContactFormType;
use Archetype\DemoBundle\Repository\BookRepository;
use Archetype\DemoBundle\Service\DemoService;
use Archetype\DemoBundle\ViewModel\DemoViewModel;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Service\FormHandler;
use Tests\Archetype\DemoBundle\Fixtures\BookFixture;

class DemoServiceTest extends TestCase
{
    protected $repository;
    protected $handler;
    protected $service;

    protected function setUp(): void
    {
        $this->repository = $this->prophesize(BookRepository::class);
        $this->handler = $this->prophesize(FormHandler::class);

        $this->service = new DemoService(
            $this->repository->reveal(),
            $this->handler->reveal()
        );
    }

    /**
     * @test
     */
    public function itGeneratesDemoViewModel()
    {
        $expectedBooks = [BookFixture::create()];

        $this->repository->findBooks()->willReturn($expectedBooks);
        $this->handler->handleForm(ContactFormType::class, Argument::type(DemoViewModel::class))
            ->willReturnArgument(1);

        $model = $this->service->getDemoViewModel();

        $this->assertInstanceOf(DemoViewModel::class, $model);
        $this->assertSame($model->getBooks(), $expectedBooks);
    }
}

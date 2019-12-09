<?php

namespace Tests\Runroom\CookiesBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Service\FormHandler;
use Runroom\CookiesBundle\Entity\CookiesPage;
use Runroom\CookiesBundle\Form\Type\CookiesFormType;
use Runroom\CookiesBundle\Repository\CookiesPageRepository;
use Runroom\CookiesBundle\Service\CookiesPageService;
use Runroom\CookiesBundle\ViewModel\CookiesPageViewModel;

class CookiesPageServiceTest extends TestCase
{
    protected const COOKIES = [];

    protected $repository;
    protected $handler;
    protected $service;

    protected function setUp(): void
    {
        $this->repository = $this->prophesize(CookiesPageRepository::class);
        $this->handler = $this->prophesize(FormHandler::class);

        $this->service = new CookiesPageService(
            $this->repository->reveal(),
            $this->handler->reveal(),
            self::COOKIES
        );
    }

    /**
     * @test
     */
    public function itGetsViewModel()
    {
        $cookiesPage = $this->prophesize(CookiesPage::class);
        $this->repository->find()->shouldBeCalled()->willReturn($cookiesPage->reveal());

        $this->handler
            ->handleForm(CookiesFormType::class, Argument::type(CookiesPageViewModel::class))
            ->shouldBeCalled()
            ->willReturnArgument(1);

        $viewModel = $this->service->getViewModel();

        $this->assertInstanceOf(CookiesPageViewModel::class, $viewModel);
        $this->assertSame($viewModel->getCookiesPage(), $cookiesPage->reveal());
    }
}

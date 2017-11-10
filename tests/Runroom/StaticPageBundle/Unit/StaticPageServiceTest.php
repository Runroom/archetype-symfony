<?php

namespace Tests\Runroom\StaticPageBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\StaticPageBundle\Entity\StaticPage;
use Runroom\StaticPageBundle\Repository\StaticPageRepository;
use Runroom\StaticPageBundle\Service\StaticPageService;
use Runroom\StaticPageBundle\ViewModel\StaticPageViewModel;

class StaticPageServiceTest extends TestCase
{
    const STATIC_SLUG = 'slug';

    protected function setUp()
    {
        $this->repository = $this->prophesize(StaticPageRepository::class);

        $this->service = new StaticPageService($this->repository->reveal());
    }

    /**
     * @test
     */
    public function itGetsStaticViewModel()
    {
        $staticPage = new StaticPage();

        $this->repository->findStaticPage(self::STATIC_SLUG)->willReturn($staticPage);

        $model = $this->service->getStaticPageViewModel(self::STATIC_SLUG);

        $this->assertInstanceOf(StaticPageViewModel::class, $model);
        $this->assertSame($staticPage, $model->getStaticPage());
    }
}

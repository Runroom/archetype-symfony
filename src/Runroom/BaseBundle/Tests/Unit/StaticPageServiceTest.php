<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Runroom\BaseBundle\Entity\StaticPage;
use Runroom\BaseBundle\Service\StaticPageService;

class StaticPageServiceTest extends \PHPUnit_Framework_TestCase
{
    const STATIC_SLUG = 'slug';

    public function setUp()
    {
        $this->repository = $this->prophesize('Runroom\BaseBundle\Repository\StaticPageRepository');

        $this->service = new StaticPageService(
            $this->repository->reveal()
        );
    }

    /**
     * @test
     */
    public function itGetsStaticViewModel()
    {
        $static = new StaticPage();

        $this->repository->findStaticPage(self::STATIC_SLUG)
            ->willReturn($static);

        $model = $this->service->getStaticPageViewModel(self::STATIC_SLUG);

        $this->assertInstanceOf('Runroom\BaseBundle\ViewModel\StaticPageViewModel', $model);
        $this->assertSame($static, $model->getStaticPage());
    }

    /**
     * @test
     */
    public function itSetsFooterStaticPagesOnPageEvent()
    {
        $expected_footer_static_pages = [];

        $event = $this->prophesize('Runroom\BaseBundle\Event\PageEvent');
        $page = $this->prophesize('Runroom\BaseBundle\ViewModel\PageViewModel');

        $event->getPage()
            ->willReturn($page->reveal());

        $this->repository->findFooterStaticPages()
            ->willReturn($expected_footer_static_pages);

        $page->setFooterStaticPages($expected_footer_static_pages)
            ->shouldBeCalled();

        $event->setPage($page->reveal())
            ->shouldBeCalled();

        $this->service->onPageEvent($event->reveal());
    }
}

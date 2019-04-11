<?php

namespace Tests\Runroom\CookiesBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Event\PageRenderEvent;
use Runroom\BaseBundle\ViewModel\CookiesViewModelInterface;
use Runroom\BaseBundle\ViewModel\PageViewModel;
use Runroom\CookiesBundle\Service\CookiesService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class CookiesServiceTest extends TestCase
{
    const PERFORMANCE_COOKIES = ['cookie 1', 'cookie 2', 'cookie 3', 'cookie 4'];
    const TARGETING_COOKIES = ['cookie 5', 'cookie 6', 'cookie 7', 'cookie 8'];

    protected $requestStack;
    protected $service;

    protected function setUp(): void
    {
        $this->requestStack = $this->prophesize(RequestStack::class);

        $this->service = new CookiesService(
            $this->buildCookiesArray(),
            $this->requestStack->reveal()
        );
    }

    /**
     * @dataProvider requestProvider
     * @test
     */
    public function itSetsCookies($cookies, $performanceIsAccepted, $targetingIsAccepted)
    {
        $request = new Request([], [], [], $cookies);

        $this->requestStack->getCurrentRequest()->shouldBeCalled()->willReturn($request);

        $event = $this->configurePageRenderEvent();

        $this->service->onPageRender($event);

        $cookies = $event->getPageViewModel()->getCookies();

        $this->assertInstanceOf(CookiesViewModelInterface::class, $cookies);
        $this->assertSame(self::PERFORMANCE_COOKIES, $cookies->getPerformanceCookies());
        $this->assertSame(self::TARGETING_COOKIES, $cookies->getTargetingCookies());
        $this->assertEquals($performanceIsAccepted, $cookies->getPerformanceIsAccepted());
        $this->assertEquals($targetingIsAccepted, $cookies->getTargetingIsAccepted());
    }

    public function requestProvider(): array
    {
        return [
            [[], null, null],
            [['performance_cookie' => 'true'], true, null],
            [['performance_cookie' => 'false', 'targeting_cookie' => 'true'], false, true],
            [['performance_cookie' => 'true', 'targeting_cookie' => 'true'], true, true],
        ];
    }

    protected function configurePageRenderEvent(): PageRenderEvent
    {
        $response = $this->prophesize(Response::class);
        $page = new PageViewModel();

        return new PageRenderEvent('view', $page, $response->reveal());
    }

    protected function buildCookiesArray(): array
    {
        return [
            'performance_cookies' => [
                ['name' => ['category 1'], 'cookies' => ['cookie 1', 'cookie 2']],
                ['name' => ['category 2'], 'cookies' => ['cookie 3', 'cookie 4']],
            ],
            'targeting_cookies' => [
                ['name' => ['category 3'], 'cookies' => ['cookie 5', 'cookie 6']],
                ['name' => ['category 4'], 'cookies' => ['cookie 7', 'cookie 8']],
            ],
        ];
    }
}

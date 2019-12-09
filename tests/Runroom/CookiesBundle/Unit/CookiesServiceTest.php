<?php

namespace Tests\Runroom\CookiesBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Event\PageRenderEvent;
use Runroom\BaseBundle\ViewModel\PageViewModel;
use Runroom\CookiesBundle\Service\CookiesService;
use Runroom\CookiesBundle\ViewModel\CookiesViewModel;
use Symfony\Component\HttpFoundation\Response;

class CookiesServiceTest extends TestCase
{
    protected const PERFORMANCE_COOKIES = ['cookie 1', 'cookie 2', 'cookie 3', 'cookie 4'];
    protected const TARGETING_COOKIES = ['cookie 5', 'cookie 6', 'cookie 7', 'cookie 8'];

    protected $requestStack;
    protected $service;

    protected function setUp(): void
    {
        $this->service = new CookiesService($this->buildCookiesArray());
    }

    /**
     * @test
     */
    public function itSetsCookies()
    {
        $event = $this->configurePageRenderEvent();

        $this->service->onPageRender($event);

        $cookies = $event->getPageViewModel()->getCookies();

        $this->assertInstanceOf(CookiesViewModel::class, $cookies);
        $this->assertSame(self::PERFORMANCE_COOKIES, $cookies->getPerformanceCookies());
        $this->assertSame(self::TARGETING_COOKIES, $cookies->getTargetingCookies());
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

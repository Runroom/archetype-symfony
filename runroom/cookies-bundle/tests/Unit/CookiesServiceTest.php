<?php

namespace Runroom\CookiesBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Runroom\CookiesBundle\Service\CookiesService;
use Runroom\CookiesBundle\ViewModel\CookiesViewModel;
use Runroom\RenderEventBundle\Event\PageRenderEvent;
use Runroom\RenderEventBundle\ViewModel\PageViewModel;
use Symfony\Component\HttpFoundation\Response;

class CookiesServiceTest extends TestCase
{
    use ProphecyTrait;

    private const PERFORMANCE_COOKIES = ['cookie 1', 'cookie 2', 'cookie 3', 'cookie 4'];
    private const TARGETING_COOKIES = ['cookie 5', 'cookie 6', 'cookie 7', 'cookie 8'];

    /** @var CookiesService */
    private $service;

    protected function setUp(): void
    {
        $this->service = new CookiesService($this->buildCookiesArray());
    }

    /** @test */
    public function itSetsCookies(): void
    {
        $event = $this->configurePageRenderEvent();

        $this->service->onPageRender($event);

        $cookies = $event->getPageViewModel()->getContext('cookies');

        $this->assertInstanceOf(CookiesViewModel::class, $cookies);
        $this->assertSame(self::PERFORMANCE_COOKIES, $cookies->getPerformanceCookies());
        $this->assertSame(self::TARGETING_COOKIES, $cookies->getTargetingCookies());
    }

    private function configurePageRenderEvent(): PageRenderEvent
    {
        return new PageRenderEvent('view', new PageViewModel(), new Response());
    }

    private function buildCookiesArray(): array
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
